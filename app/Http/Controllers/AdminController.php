<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        
        $totalBuku = Book::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $sedangDipinjam = Transaction::where('status', 'dipinjam')->count();
        $totalTransaksi = Transaction::count();

        
        $latestTransactions = Transaction::with(['user', 'book'])
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalSiswa',
            'sedangDipinjam',
            'totalTransaksi',
            'latestTransactions'
        ));
    }
}
