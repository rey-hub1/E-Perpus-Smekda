<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // 1. Menampilkan semua buku
    public function index()
    {

        $books = Book::latest()->paginate(10); // Ambil semua data buku
        return view('books.index', compact('books'));
    }

    // 2. Menampilkan Form Tambah Buku
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // 3. Proses Simpan Buku ke Database
    public function store(Request $request)
    {
        // 1. Definisikan Aturan (Rules)
        $rules = [
            'category_id' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:4096',
        ];

        // 2. Definisikan Pesan Bahasa Indonesia (Messages)
        $messages = [
            'required' => ':attribute wajib diisi, jangan dikosongin ya!',
            'integer' => ':attribute harus berupa angka.',
            'image' => ':attribute harus berupa file gambar.',
            'mimes' => 'Format :attribute harus jpeg, png, atau jpg.',
            'max' => 'Ukuran :attribute terlalu besar (maksimal 5MB).',
            'uploaded' => 'Gagal mengupload :attribute. Mungkin ukurannya kegedean buat server.',
        ];

        $request->validate($rules, $messages);

        $input = $request->all();

        // Cek kalau ada upload gambar
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $imageName);
            $input['gambar'] = $imageName;
        }

        $input['slug'] = Str::slug($request->judul);
        Book::create($input);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {

        $rules = [
            'category_id' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:4096',
        ];

        $messages = [
            'required' => ':attribute wajib diisi, jangan dikosongin ya!',
            'integer' => ':attribute harus berupa angka.',
            'image' => ':attribute harus berupa file gambar.',
            'mimes' => 'Format :attribute harus jpeg, png, atau jpg.',
            'max' => 'Ukuran :attribute terlalu besar (maksimal 5MB).',
            'uploaded' => 'Gagal mengupload :attribute. Mungkin ukurannya kegedean buat server.',
        ];

        $request->validate($rules, $messages);

        $input = $request->all();

        // Cek kalau user upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama biar server gak penuh (Opsional)
            if ($book->gambar && file_exists(public_path('images/' . $book->gambar))) {
                unlink(public_path('images/' . $book->gambar));
            }

            // Upload gambar baru
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $imageName);
            $input['gambar'] = $imageName;
        } else {
            // Kalau gak upload gambar baru, pake gambar lama
            unset($input['gambar']);
        }

        // Cek apakah judul berubah, jika ya, update slug
        if ($request->judul !== $book->judul) {
            $input['slug'] = Str::slug($request->judul);
        }

        $book->update($input);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    // 6. Hapus Buku
    public function destroy(Book $book)
    {
        // Hapus file gambarnya juga
        if ($book->gambar && file_exists(public_path('images/' . $book->gambar))) {
            unlink(public_path('images/' . $book->gambar));
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari perpustakaan.');
    }

    public function favorite(Book $book)
    {
        $book->update([
            'favorite' => !$book->favorite
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari daftar favorit.');
    }

    // ADMIN
    public function featured(Book $book)
    {
        $book->update([
            'featured' => !$book->featured
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari daftar unggulan.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
