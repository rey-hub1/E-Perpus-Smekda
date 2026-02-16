<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function home(Request $request)
    {

        // 1. Siapkan Query (Belum dieksekusi)
        $query = Book::query();
        $NewBook = Book::latest()->take(4)->get();

        // 2. Cek apakah ada pencarian?
        if ($request->has('search')) {
            $keyword = $request->search;
            // Cari berdasarkan Judul ATAU Penulis
            $query->where('judul', 'LIKE', '%' . $keyword . '%')
                ->orWhere('penulis', 'LIKE', '%' . $keyword . '%');
        }

        // 3. Ambil datanya (Get)
        $books = $query->paginate(10);

        return view('student.home', compact('books', 'NewBook'));
    }
    public function katalog(Request $request)
    {
        // 1. Siapkan Query (Belum dieksekusi)
        $query = Book::query();

        // 2. Cek apakah ada pencarian?
        if ($request->has('search')) {
            $keyword = $request->search;
            // Cari berdasarkan Judul ATAU Penulis
            $query->where('judul', 'LIKE', '%' . $keyword . '%')
                ->orWhere('penulis', 'LIKE', '%' . $keyword . '%');
        }

        // 3. Ambil datanya (Get)
        $books = $query->paginate(10);

        return view('student.katalog', compact('books'));
    }
}
