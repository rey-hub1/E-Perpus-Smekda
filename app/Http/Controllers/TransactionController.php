<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // Fungsi untuk memproses peminjaman
    public function pinjam(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // 1. Cek Stok Dulu
        if ($book->stok < 1) {
            return back()->with('error', 'Yah, stok bukunya habis dipinjam orang lain! 😭');
        }

        // 2. Cek apakah siswa ini SEDANG meminjam buku yang SAMA (biar gak double)
        $sedangPinjam = Transaction::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sedangPinjam) {
            return back()->with('error', 'Kamu masih meminjam buku ini, balikin dulu ya sebelum pinjam lagi! 😅');
            }

            // Mencek apakah user minjam buku lebih dari 3
            $pinjamBerapa = Transaction::where('user_id', Auth::id())->where('status', 'dipinjam')->count();

            if ($pinjamBerapa > 3) {
            return back()->with('error', 'Kamu sudah meminjam 3 buku, balikan dulu baru nanti pinjem lagi ya! 😅');

        }

        // 3. Catat Transaksi
        Transaction::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'tanggal_pinjam' => Carbon::now(), // Tanggal hari ini
            'status' => 'dipinjam',
        ]);

        // 4. Kurangi Stok Buku
        $book->decrement('stok');

        return back()->with('success', 'Asik! Buku berhasil dipinjam. Jangan lupa dibaca ya! 📖');
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
        };

        $transaction->update([
            'status' => 'kembali',
            'tanggal_kembali' => Carbon::now()
        ]);

        $transaction->book->increment('stok');

        return back()->with('success', 'Terima kasih sudah mengembalikan buku tepat waktu! 👍');
    }
    public function indexAdmin()
    {
        $transactions = Transaction::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transactions', compact('transactions'));
    }

    // Pengambilan sama admin
    public function adminReturn($id)
    {
        $transaction = Transaction::findOrFail($id);


        if ($transaction->status == 'kembali') {
            return back()->with('error', 'Buku Ini udah di kembaliin');
        }

        $transaction->update([
            'status' => 'kembali',
            'tanggal_kembali' => Carbon::now()
        ]);

        $transaction->book->increment('stok');

        return back()->with('success', 'Buku sudah di kembalikan sama admin');
    }
    public function adminPinjam($id)
    {
        $transaction = Transaction::findOrFail($id);


        if ($transaction->status == 'pinjam') {
            return back()->with('error', 'Buku Ini udah di kembaliin');
        }

        $transaction->update([
            'status' => 'dipinjam',
            'tanggal_kembali' => null
        ]);

        $transaction->book->decrement('stok');

        return back()->with('success', 'Buku sudah di kembalikan sama admin');
    }
}
