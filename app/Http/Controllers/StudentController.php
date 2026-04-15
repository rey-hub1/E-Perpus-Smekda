<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function home(Request $request)
    {

        $popularBooks = Book::where('featured', 1)
            ->with('category')
            ->take(10)
            ->get();

        $query = Book::query()->with('category');

        // 2. Cek apakah ada pencarian?
        if ($request->has('search')) {
            $keyword = $request->search;
            // Cari berdasarkan Judul ATAU Penulis
            $query->where('judul', 'LIKE', '%' . $keyword . '%')
                ->orWhere('penulis', 'LIKE', '%' . $keyword . '%');
        }

        $categories = Category::withCount('books')->orderBy('name')->get();

        // 3. Ambil datanya (Get)
        $books = $query->paginate(10);

        return view('student.home', compact('books', 'popularBooks', 'categories'));
    }
    public function katalog(Request $request)
    {
        $query = Book::query()->with('category');
        $categories = Category::orderBy('name')->get();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('penulis', 'LIKE', '%' . $keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->paginate(30)->withQueryString();

        return view('student.katalog', compact('books', 'categories'));
    }
}
