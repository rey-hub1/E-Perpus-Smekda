<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UserLibrary;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $library = auth()->user()
            ->library()
            ->with('book.category')
            ->latest()
            ->get();

        return view('student.library', compact('library'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate(['status' => 'required|in:saved']);

        UserLibrary::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            ['status'  => 'saved']
        );

        return back()->with('success', "\"$book->judul\" ditambahkan ke Library.");
    }

    public function destroy(Book $book)
    {
        UserLibrary::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->delete();

        return back()->with('success', "Buku dihapus dari library.");
    }
}
