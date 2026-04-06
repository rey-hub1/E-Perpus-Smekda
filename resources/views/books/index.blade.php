@extends('layouts.admin')

@section('title', 'Koleksi Buku')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Koleksi Buku</h1>
            <p class="text-sm text-gray-500">Kelola dan organisir koleksi perpustakaan</p>
        </div>
        <a href="{{ route('admin.books.create') }}"
            class="bg-primary text-white font-semibold px-5 py-2 rounded-lg hover:bg-secondary transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Buku
        </a>
    </div>

    @if (session('success'))
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

        <div
            class="rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow bg-gradient-to-br from-primary to-secondary text-background">
            <p class="text-sm font-medium mb-1 opacity-90">Total Buku</p>
            <p class="text-3xl font-bold">{{ $books->total() }}</p>
        </div>

        <div class="rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow bg-secondary text-background">
            <p class="text-sm font-medium mb-1 opacity-90">Total Stok</p>
            <p class="text-3xl font-bold">{{ $books->sum('stok') }}</p>
        </div>

        <div class="rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow bg-accent text-background">
            <p class="text-sm font-medium mb-1 opacity-90">Buku Unggulan</p>
            <p class="text-3xl font-bold">{{ \App\Models\Book::where('featured', true)->count() }}</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="mb-6">
        <form action="{{ route('admin.books.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari judul buku atau penulis..." 
                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none transition-all">
                <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <button type="submit" class="px-8 py-3 bg-secondary text-background rounded-xl font-bold hover:opacity-90 transition-all shadow-md">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.books.index') }}" class="px-6 py-3 bg-gray-100 text-text rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center">
                    Reset
                </a>
            @endif
        </form>
    </div>
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
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Unggulan</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($books as $book)
                        <tr class="hover:bg-gray-50 transition-all duration-200">

                            <td class="p-5 w-32">
                                @if ($book->gambar)
                                    <img src="{{ $book->cover_url }}"
                                        class="w-20 h-28 object-cover rounded-lg shadow-md" alt="{{ $book->judul }}">
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
                                <span
                                    class="inline-flex items-center justify-center w-16 h-10 rounded-full font-bold shadow-sm bg-gradient-to-br from-primary to-secondary text-background">
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
                                @if ($book->featured)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        ⭐ Featured
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-500">
                                        Reguler
                                    </span>
                                @endif
                            </td>

                            <td class="p-5 text-center  justify-center gap-2 h-full my-auto">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.books.featured', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg  text-white text-sm font-medium hover:opacity-90">
                                            @if ($book->featured)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-star-icon lucide-star fill-yellow-500 stroke-yellow-500">
                                                    <path
                                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-star-icon lucide-star  stroke-text">
                                                    <path
                                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                                </svg>
                                            @endif
                                        </button>

                                    </form>
                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                        class="px-4 py-2 rounded-lg bg-accent text-background text-sm font-medium hover:opacity-90">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin mau menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-secondary text-white text-sm font-medium hover:opacity-90">
                                            Hapus
                                        </button>
                                    </form>
                                </div>


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
