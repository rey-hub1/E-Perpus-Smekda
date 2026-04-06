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

        $reading  = $library->where('status', 'reading');
        $saved    = $library->where('status', 'saved');
        $finished = $library->where('status', 'finished');

        return view('student.library', compact('library', 'reading', 'saved', 'finished'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate(['status' => 'required|in:reading,saved,finished']);

        UserLibrary::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            ['status'  => $request->status]
        );

        $label = match($request->status) {
            'reading'  => 'Sedang Dibaca',
            'saved'    => 'Tersimpan',
            'finished' => 'Selesai Dibaca',
        };

        return back()->with('success', "\"$book->judul\" ditambahkan ke $label.");
    }

    public function destroy(Book $book)
    {
        UserLibrary::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->delete();

        return back()->with('success', "Buku dihapus dari library.");
    }
}
