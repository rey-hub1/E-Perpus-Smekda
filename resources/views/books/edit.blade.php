@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-cta">
    <div class="mb-6 pb-4 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-primary">Edit Data Buku ✏️</h2>
        <p class="text-gray-500 text-sm">Perbarui informasi buku di bawah ini.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT') <div>
            <label class="block text-primary font-semibold mb-2">Judul Buku</label>
            <input type="text" name="judul" value="{{ old('judul', $book->judul) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
        </div>
        
        <div class="flex flex-col w-full">
            <label for="category_id" class="block text-primary font-semibold mb-2">Kategori</label>
            <select name="category_id" class="bg-gray-50 rounded-lg p-2 px-3 mb-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-accent transition">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-primary font-semibold mb-2">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis', $book->penulis) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
            </div>
            <div>
                <label class="block text-primary font-semibold mb-2">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $book->penerbit) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-primary font-semibold mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
            </div>
            <div>
                <label class="block text-primary font-semibold mb-2">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $book->stok) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
            </div>
        </div>

        <div>
            <label class="block text-primary font-semibold mb-2">Sinopsis / Deskripsi</label>
            <textarea name="deskripsi" rows="5" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">{{ old('deskripsi', $book->deskripsi) }}</textarea>
        </div>

        <div class="flex gap-6 items-start">
            <div class="flex-1">
                <label class="block text-primary font-semibold mb-2">Ganti Cover (Opsional)</label>
                <input type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent/20 file:text-primary hover:file:bg-accent/40">
                <p class="text-xs text-gray-400 mt-2">*Kosongkan jika tidak ingin mengubah cover.</p>
            </div>

            @if($book->gambar)
                <div class="w-24 text-center">
                    <p class="text-xs text-gray-500 mb-1">Cover Saat Ini:</p>
                    <img src="/images/{{ $book->gambar }}" class="w-full h-auto rounded shadow">
                </div>
            @endif
        </div>

        <div class="flex justify-end pt-4">
            <a href="{{ route('admin.books.index') }}" class="mr-4 px-6 py-3 text-gray-500 hover:text-gray-700 font-medium">Batal</a>
            <button type="submit" class="bg-cta text-primary font-bold px-8 py-3 rounded-lg hover:bg-yellow-400 transition shadow-lg transform hover:-translate-y-1">
                Update Buku
            </button>
        </div>
    </form>
</div>
@endsection
