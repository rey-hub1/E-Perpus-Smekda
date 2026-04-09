<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    // 1. Menampilkan semua buku
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $keyword = $request->search;
            $query->where('judul', 'LIKE', '%' . $keyword . '%')
                ->orWhere('penulis', 'LIKE', '%' . $keyword . '%');
        }

        $books = $query->latest()->paginate(10);
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

        // 3. Generate Unique Slug (Issue 7)
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;
        while (Book::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $input['slug'] = $slug;

        // Cek jika ada gambar hasil crop (Base64)
        if ($request->filled('cropped_image')) {
            $imageData = $request->input('cropped_image');
            $filename = time() . '_cropped.jpg';
            $path = 'images/' . $filename;
            
            // Inisialisasi ImageManager untuk memproses base64
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageData);
            
            // Simpan ke storage
            $image->save(storage_path('app/public/' . $path));
            $input['gambar'] = $path;
        } 
        // Fallback: Cek kalau ada upload gambar standar (non-JS)
        else if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->cover(640, 853);
            
            $path = 'images/' . $filename;
            $image->save(storage_path('app/public/' . $path));
            $input['gambar'] = $path;
        }

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

        // Cek jika ada gambar hasil crop baru (Base64)
        if ($request->filled('cropped_image')) {
            // Hapus gambar lama
            if ($book->gambar) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($book->gambar)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($book->gambar);
                }
            }

            $imageData = $request->input('cropped_image');
            $filename = time() . '_cropped.jpg';
            $path = 'images/' . $filename;
            
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageData);
            $image->save(storage_path('app/public/' . $path));
            
            $input['gambar'] = $path;
        } 
        // Fallback: Upload & Resize gambar baru via file input
        else if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($book->gambar) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($book->gambar)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($book->gambar);
                }
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->cover(640, 853);
            
            $path = 'images/' . $filename;
            $image->save(storage_path('app/public/' . $path));
            
            $input['gambar'] = $path;
        } else {
            // Kalau gak upload gambar baru, pake gambar lama
            unset($input['gambar']);
        }

        // Cek apakah judul berubah, jika ya, update slug secara unik
        if ($request->judul !== $book->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $count = 1;
            while (Book::where('slug', $slug)->where('id', '!=', $book->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $input['slug'] = $slug;
        }

        $book->update($input);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    // 6. Hapus Buku
    public function destroy(Book $book)
    {
        // Hapus file gambarnya juga
        if ($book->gambar) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($book->gambar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->gambar);
            } elseif (file_exists(public_path('images/' . $book->gambar))) {
                @unlink(public_path('images/' . $book->gambar));
            }
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari perpustakaan.');
    }

    public function favorite(Book $book)
    {
        auth()->user()->favoriteBooks()->toggle($book->id);

        return redirect()->back()->with('success', 'Daftar favorit berhasil diperbarui!');
    }

    // ADMIN
    public function featured(Book $book)
    {
        $book->update([
            'featured' => !$book->featured
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari daftar unggulan.');
    }

    public function bulkCreate()
    {
        $categories = Category::all();
        return view('books.bulk-create', compact('categories'));
    }

    public function bulkStore(Request $request)
    {
        $booksData = $request->input('books', []);
        $croppedImages = $request->input('cropped_images', []);

        if (empty($booksData)) {
            return redirect()->back()->withErrors(['Data buku tidak boleh kosong.']);
        }

        $manager = new ImageManager(new Driver());

        foreach ($booksData as $index => $bookData) {
            // Generate unique slug
            $slug = Str::slug($bookData['judul'] ?? 'buku');
            $originalSlug = $slug;
            $count = 1;
            while (Book::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $bookData['slug'] = $slug;

            // Sanitize
            unset($bookData['_token']);

            // Handle cropped image
            if (!empty($croppedImages[$index])) {
                $imageData = $croppedImages[$index];
                $filename = time() . '_' . $index . '_bulk.jpg';
                $path = 'images/' . $filename;

                $image = $manager->read($imageData);
                $image->save(storage_path('app/public/' . $path));
                $bookData['gambar'] = $path;
            }

            Book::create($bookData);
        }

        $count = count($booksData);
        return redirect()->route('admin.books.index')
            ->with('success', $count . ' buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
