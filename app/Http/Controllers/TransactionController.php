<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function showJadwal($bookId)
    {
        $user = Auth::user();

        if (!$this->profileLengkap($user)) {
            return redirect()->route('profile')->with('error', 'Harap lengkapi profil kamu dulu (NISN, Kelas, Nomor HP) sebelum meminjam buku.');
        }

        $book = Book::findOrFail($bookId);

        if ($book->stok < 1) {
            return redirect()->route('book.show', $book->slug)->with('error', 'Stok buku ini sudah habis.');
        }

        if ($this->sedangPinjamBuku($user->id, $book->id)) {
            return redirect()->route('book.show', $book->slug)->with('error', 'Kamu masih meminjam buku ini, kembalikan dulu sebelum pinjam lagi.');
        }

        if ($this->batasPinjam($user->id)) {
            return redirect()->route('book.show', $book->slug)->with('error', 'Kamu sudah meminjam 3 buku, kembalikan dulu sebelum pinjam lagi.');
        }

        return view('student.jadwal-pinjam', compact('book'));
    }

    public function pinjam(Request $request, $bookId)
    {
        $request->validate([
            'tanggal_ambil' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'tanggal_ambil.required'       => 'Pilih tanggal pengambilan buku.',
            'tanggal_ambil.date'           => 'Format tanggal tidak valid.',
            'tanggal_ambil.after_or_equal' => 'Tanggal pengambilan tidak boleh sebelum hari ini.',
        ]);

        $user = Auth::user();

        if (!$this->profileLengkap($user)) {
            return redirect()->route('profile')->with('error', 'Harap lengkapi profil kamu dulu (NISN, Kelas, Nomor HP) sebelum meminjam buku.');
        }

        $book = Book::findOrFail($bookId);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku ini sudah habis dipinjam orang lain.');
        }

        if ($this->sedangPinjamBuku($user->id, $book->id)) {
            return back()->with('error', 'Kamu masih meminjam buku ini.');
        }

        if ($this->batasPinjam($user->id)) {
            return back()->with('error', 'Kamu sudah meminjam 3 buku, kembalikan dulu sebelum pinjam lagi.');
        }

        $tanggalAmbil = Carbon::parse($request->tanggal_ambil);

        DB::transaction(function () use ($book, $tanggalAmbil, $user) {
            Book::where('id', $book->id)->lockForUpdate()->first();

            Transaction::create([
                'user_id'        => $user->id,
                'book_id'        => $book->id,
                'tanggal_pinjam' => Carbon::now(),
                'tanggal_ambil'  => $tanggalAmbil,
                'due_date'       => null,
                'status'         => 'menunggu_pengambilan',
                'pickup_code'    => $this->generateKode('AMB', 'pickup_code'),
            ]);

            $book->decrement('stok');
            $book->increment('read_count');
        });

        return redirect()->route('student.history')
            ->with('success', "Peminjaman berhasil dijadwalkan! Silahkan ambil buku di perpustakaan pada tanggal {$tanggalAmbil->translatedFormat('d F Y')}.");
    }

    public function batalkan($id)
    {
        $trx = Transaction::findOrFail($id);

        abort_if($trx->user_id !== Auth::id(), 403);

        if ($trx->status !== 'menunggu_pengambilan') {
            return back()->with('error', 'Peminjaman ini tidak bisa dibatalkan.');
        }

        $trx->update(['status' => 'dibatalkan', 'pickup_code' => null]);
        $trx->book->increment('stok');

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    public function history()
    {
        $tab = request('tab', 'aktif');

        $transactions = Transaction::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $filtered = $tab === 'selesai'
            ? $transactions->whereIn('status', ['kembali', 'dibatalkan'])
            : $transactions->whereIn('status', ['menunggu_pengambilan', 'dipinjam', 'mengembalikan']);

        return view('student.history', compact('transactions', 'filtered', 'tab'));
    }

    public function kembalikan($id)
    {
        $trx = Transaction::findOrFail($id);

        abort_if($trx->user_id !== Auth::id(), 403);

        if ($trx->status !== 'dipinjam') {
            return back()->with('error', 'Buku ini tidak bisa dikembalikan saat ini.');
        }

        $trx->update([
            'status'      => 'mengembalikan',
            'return_code' => $this->generateKode('KMB', 'return_code'),
        ]);

        return back();
    }

    // --- Admin ---

    public function indexAdmin()
    {
        $transactions = Transaction::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transactions', compact('transactions'));
    }

    public function adminAccAmbilByCode(Request $request)
    {
        $request->validate(['pickup_code' => 'required|string']);

        $trx = Transaction::with(['user', 'book'])
            ->where('pickup_code', strtoupper(trim($request->pickup_code)))
            ->where('status', 'menunggu_pengambilan')
            ->first();

        if (!$trx) {
            return back()->with('error', 'Kode pengambilan tidak valid atau sudah diproses.');
        }

        $this->prosesAmbil($trx);

        return back()->with('success', "Buku \"{$trx->book->judul}\" berhasil diserahkan ke {$trx->user->name}.");
    }

    public function adminAccAmbil($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->status !== 'menunggu_pengambilan') {
            return back()->with('error', 'Status transaksi bukan menunggu pengambilan.');
        }

        $this->prosesAmbil($trx);

        return back()->with('success', 'Buku berhasil diserahkan kepada peminjam.');
    }

    public function adminReturnByCode(Request $request)
    {
        $request->validate(['return_code' => 'required|string']);

        $trx = Transaction::with(['user', 'book'])
            ->where('return_code', strtoupper(trim($request->return_code)))
            ->where('status', 'mengembalikan')
            ->first();

        if (!$trx) {
            return back()->with('error', 'Kode tidak valid atau buku sudah diproses.');
        }

        $denda = $this->prosesKembali($trx);
        $msg   = "Buku \"{$trx->book->judul}\" dari {$trx->user->name} berhasil dikembalikan.";
        if ($denda > 0) {
            $msg .= " Denda: Rp" . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $msg);
    }

    public function adminReturn($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->status === 'kembali') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $this->prosesKembali($trx);

        return back()->with('success', 'Buku berhasil dikembalikan secara manual.');
    }

    public function adminPinjam($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->status === 'dipinjam') {
            return back()->with('error', 'Buku ini masih dipinjam.');
        }

        $trx->update([
            'status'          => 'dipinjam',
            'tanggal_kembali' => null,
            'fine'            => 0,
            'due_date'        => Carbon::now()->addDays(Transaction::loanDays()),
        ]);

        $trx->book->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjamkan kembali.');
    }

    public function adminBatalAmbil($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->status !== 'menunggu_pengambilan') {
            return back()->with('error', 'Status transaksi bukan menunggu pengambilan.');
        }

        $trx->update(['status' => 'dibatalkan']);
        $trx->book->increment('stok');

        return back()->with('success', 'Peminjaman dibatalkan, buku kembali ke rak.');
    }

    // --- Private helpers ---

    private function profileLengkap($user): bool
    {
        return !empty($user->nisn) && !empty($user->kelas) && !empty($user->phone);
    }

    private function sedangPinjamBuku(int $userId, int $bookId): bool
    {
        return Transaction::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('status', 'dipinjam')
            ->exists();
    }

    private function batasPinjam(int $userId): bool
    {
        return Transaction::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count() >= 3;
    }

    private function generateKode(string $prefix, string $kolom): string
    {
        do {
            $kode = $prefix . '-' . strtoupper(Str::random(6));
        } while (Transaction::where($kolom, $kode)->exists());

        return $kode;
    }

    private function prosesAmbil(Transaction $trx): void
    {
        $trx->update([
            'status'         => 'dipinjam',
            'tanggal_pinjam' => Carbon::now(),
            'due_date'       => Carbon::now()->addDays(Transaction::loanDays()),
            'pickup_code'    => null,
        ]);
    }

    private function prosesKembali(Transaction $trx): int
    {
        $denda = $trx->denda_berjalan;

        $trx->update([
            'status'          => 'kembali',
            'tanggal_kembali' => Carbon::now(),
            'fine'            => $denda,
            'return_code'     => null,
        ]);

        $trx->book->increment('stok');

        return $denda;
    }
}
