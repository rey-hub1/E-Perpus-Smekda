<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // Halaman jadwal peminjaman
    public function showJadwal($bookId)
    {
        $user = Auth::user();

        if (empty($user->nisn) || empty($user->kelas) || empty($user->phone)) {
            return redirect()->route('profile')->with('error', 'Harap lengkapi profil kamu dulu (NISN, Kelas, Nomor HP) sebelum meminjam buku.');
        }

        $book = Book::findOrFail($bookId);

        if ($book->stok < 1) {
            return redirect()->route('book.show', $book->slug)->with('error', 'Stok buku ini sudah habis.');
        }

        $sedangPinjam = Transaction::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sedangPinjam) {
            return redirect()->route('book.show', $book->slug)->with('error', 'Kamu masih meminjam buku ini, kembalikan dulu sebelum pinjam lagi.');
        }

        $pinjamBerapa = Transaction::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        if ($pinjamBerapa >= 3) {
            return redirect()->route('book.show', $book->slug)->with('error', 'Kamu sudah meminjam 3 buku, kembalikan dulu sebelum pinjam lagi.');
        }

        return view('student.jadwal-pinjam', compact('book'));
    }

    // Fungsi untuk memproses peminjaman
    public function pinjam(Request $request, $bookId)
    {
        $request->validate([
            'tanggal_ambil' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'tanggal_ambil.required' => 'Pilih tanggal pengambilan buku.',
            'tanggal_ambil.date'     => 'Format tanggal tidak valid.',
            'tanggal_ambil.after_or_equal' => 'Tanggal pengambilan tidak boleh sebelum hari ini.',
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($bookId, $request) {
            $user = Auth::user();

            if (empty($user->nisn) || empty($user->kelas) || empty($user->phone)) {
                return redirect()->route('profile')->with('error', 'Harap lengkapi profil kamu dulu (NISN, Kelas, Nomor HP) sebelum meminjam buku.');
            }

            $book = Book::where('id', $bookId)->lockForUpdate()->firstOrFail();

            if ($book->stok < 1) {
                return redirect()->route('book.show', $book->slug)->with('error', 'Stok buku ini sudah habis dipinjam orang lain.');
            }

            $sedangPinjam = Transaction::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->where('status', 'dipinjam')
                ->exists();

            if ($sedangPinjam) {
                return redirect()->route('book.show', $book->slug)->with('error', 'Kamu masih meminjam buku ini, kembalikan dulu sebelum pinjam lagi.');
            }

            $pinjamBerapa = Transaction::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->count();

            if ($pinjamBerapa >= 3) {
                return redirect()->route('book.show', $book->slug)->with('error', 'Kamu sudah meminjam 3 buku, kembalikan dulu sebelum pinjam lagi.');
            }

            $tanggalAmbil = Carbon::parse($request->tanggal_ambil);
            $dueDate      = $tanggalAmbil->copy()->addDays(10);

            Transaction::create([
                'user_id'       => $user->id,
                'book_id'       => $book->id,
                'tanggal_pinjam'=> Carbon::now(),
                'tanggal_ambil' => $tanggalAmbil,
                'due_date'      => $dueDate,
                'status'        => 'dipinjam',
            ]);

            $book->decrement('stok');
            $book->increment('read_count');

            $formatAmbil = $tanggalAmbil->translatedFormat('d F Y');
            $formatDue   = $dueDate->translatedFormat('d F Y');

            return redirect()->route('student.history')
                ->with('success', "Peminjaman berhasil dijadwalkan! Silahkan ambil buku di perpustakaan pada tanggal {$formatAmbil}. Batas pengembalian: {$formatDue}.");
        });
    }
    public function history()
    {
        $transactions = Transaction::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.history', compact('transactions'));
    }

    public function kembalikan($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        if ($transaction->status !== 'dipinjam') {
            return back()->with('error', 'Buku ini tidak bisa dikembalikan saat ini.');
        }

        // Generate kode unik untuk pengembalian
        do {
            $kode = 'KMB-' . strtoupper(Str::random(6));
        } while (Transaction::where('return_code', $kode)->exists());

        $transaction->update([
            'status'      => 'mengembalikan',
            'return_code' => $kode,
        ]);

        return back();
    }
    public function indexAdmin()
    {
        $transactions = Transaction::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transactions', compact('transactions'));
    }

    // Admin konfirmasi pengembalian via kode
    public function adminReturnByCode(Request $request)
    {
        $request->validate([
            'return_code' => 'required|string',
        ]);

        $kode = strtoupper(trim($request->return_code));

        $transaction = Transaction::with(['user', 'book'])
            ->where('return_code', $kode)
            ->where('status', 'mengembalikan')
            ->first();

        if (!$transaction) {
            return back()->with('error', 'Kode tidak valid atau buku sudah diproses.');
        }

        $tanggal_kembali = Carbon::now();
        $denda = 0;

        if ($transaction->due_date && $tanggal_kembali->gt($transaction->due_date)) {
            $hari_telat = (int) $tanggal_kembali->diffInDays($transaction->due_date);
            $denda = $hari_telat * 1000;
        }

        $transaction->update([
            'status'          => 'kembali',
            'tanggal_kembali' => $tanggal_kembali,
            'fine'            => $denda,
            'return_code'     => null,
        ]);

        $transaction->book->increment('stok');

        $msg = "Buku \"{$transaction->book->judul}\" dari {$transaction->user->name} berhasil dikembalikan.";
        if ($denda > 0) {
            $msg .= " Denda: Rp" . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $msg);
    }

    // Pengembalian manual sama admin (tanpa kode)
    public function adminReturn($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'kembali') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $tanggal_kembali = Carbon::now();
        $denda = 0;

        if ($transaction->due_date && $tanggal_kembali->gt($transaction->due_date)) {
            $hari_telat = (int) $tanggal_kembali->diffInDays($transaction->due_date);
            $denda = $hari_telat * 1000;
        }

        $transaction->update([
            'status'          => 'kembali',
            'tanggal_kembali' => $tanggal_kembali,
            'fine'            => $denda,
            'return_code'     => null,
        ]);

        // Stok selalu dikembalikan karena buku belum kembali (dipinjam / mengembalikan)
        $transaction->book->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan secara manual.');
    }
    public function adminPinjam($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'dipinjam') {
            return back()->with('error', 'Buku ini masih dipinjam, belum bisa dipinjamkan ulang');
        }

        $transaction->update([
            'status' => 'dipinjam',
            'tanggal_kembali' => null,
            'fine' => 0,
            'due_date' => Carbon::now()->addDays(7),
        ]);

        $transaction->book->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjamkan kembali oleh admin');
    }
}
