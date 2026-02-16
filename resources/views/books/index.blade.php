@extends('layouts.admin')

@section('content')
    <!-- Hero Section -->
    <div class="rounded-2xl p-8 mb-6 shadow-xl bg-gradient-to-br from-secondary to-primary">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-2 drop-shadow-lg text-background">
                    📚 Koleksi Buku
                </h1>
                <p class="text-lg text-background/90">
                    Kelola dan organisir perpustakaan digital Anda
                </p>
            </div>
            <a href="{{ route('admin.books.create') }}"
                class="font-bold px-8 py-3 rounded-full bg-primary text-text hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Buku Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="border-l-4 border-accent bg-accent/10 text-text p-5 rounded-lg mb-6 shadow-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow bg-gradient-to-br from-primary to-secondary text-background">
            <p class="text-sm font-medium mb-1 opacity-90">Total Buku</p>
            <p class="text-3xl font-bold">{{ $books->total() }}</p>
        </div>

        <div class="rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow bg-secondary text-background">
            <p class="text-sm font-medium mb-1 opacity-90">Total Stok</p>
            <p class="text-3xl font-bold">{{ $books->sum('stok') }}</p>
        </div>

        <div class="rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow bg-accent text-background">
            <p class="text-sm font-medium mb-1 opacity-90">Favorit</p>
            <p class="text-3xl font-bold">{{ $books->where('favorite', true)->count() }}</p>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

        <div class="p-6 bg-gradient-to-r from-secondary to-primary text-background">
            <h3 class="text-xl font-bold">Daftar Buku</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="p-5 text-left text-xs font-bold text-gray-600 uppercase">Cover</th>
                        <th class="p-5 text-left text-xs font-bold text-gray-600 uppercase">Informasi</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Tahun</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Stok</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($books as $book)
                        <tr class="hover:bg-gray-50 transition-all duration-200">

                            <td class="p-5 w-32">
                                @if ($book->gambar)
                                    <img src="/images/{{ $book->gambar }}"
                                        class="w-20 h-28 object-cover rounded-lg shadow-md"
                                        alt="{{ $book->judul }}">
                                @endif
                            </td>

                            <td class="p-5">
                                <h4 class="font-bold text-lg text-text">
                                    {{ $book->judul }}
                                </h4>
                                <p class="text-sm text-gray-600">
                                    {{ $book->penulis }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $book->penerbit }}
                                </p>
                            </td>

                            <td class="p-5 text-center">
                                <span class="inline-flex items-center justify-center w-16 h-10 rounded-full font-bold shadow-sm bg-gradient-to-br from-primary to-secondary text-background">
                                    {{ $book->tahun_terbit }}
                                </span>
                            </td>

                            <td class="p-5 text-center">
                                @if ($book->stok > 10)
                                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700">
                                        {{ $book->stok }}
                                    </span>
                                @elseif ($book->stok > 5)
                                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-700">
                                        {{ $book->stok }}
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-700">
                                        {{ $book->stok }}
                                    </span>
                                @endif
                            </td>

                            <td class="p-5 text-center">
                                @if ($book->favorite)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-primary text-text">
                                        Favorit
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-500">
                                        Reguler
                                    </span>
                                @endif
                            </td>

                            <td class="p-5 text-center flex justify-center gap-2">

                                <a href="{{ route('admin.books.edit', $book->id) }}"
                                    class="px-4 py-2 rounded-lg bg-accent text-text text-sm font-medium hover:opacity-90">
                                    Edit
                                </a>

                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-secondary text-white text-sm font-medium hover:opacity-90">
                                        Hapus
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $books->links() }}
        </div>

    </div>
@endsection
