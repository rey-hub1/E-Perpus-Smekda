@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <div
            class="bg-primary text-white p-8 rounded-xl shadow-lg flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">

            <div class="relative z-10 text-center md:text-left w-full md:w-1/2">
                <h1 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="opacity-90">Mau baca buku apa hari ini?</p>
            </div>

            <div class="relative z-10 w-full md:w-1/2">
                <form action="{{ route('student.katalog') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search"
                        class="w-full text-gray-800 p-3 bg-background rounded-lg focus:outline-none focus:ring-4 focus:ring-accent/50 shadow-inner"
                        placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">

                    <button type="submit"
                        class="bg-cta text-primary font-bold px-6 py-3 rounded-lg bg-background hover:bg-yellow-400 transition shadow-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow animate-fade-in-up">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow animate-fade-in-up">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (request('search'))
            <div class="flex justify-between items-center px-2">
                <p class="text-gray-500">Hasil pencarian: <span
                        class="font-bold text-primary">"{{ request('search') }}"</span></p>
                <a href="{{ route('student.home') }}" class="text-red-500 text-sm hover:underline font-semibold">Reset
                    / Tampilkan Semua</a>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-20">
            @forelse ($books as $book)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col h-full">

                    <div class=" overflow-hidden bg-gray-200 relative group">
                        @if ($book->gambar)
                            <img src="/images/{{ $book->gambar }}"
                                class="w-full  object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                No Cover
                            </div>
                        @endif

                        <span
                            class="absolute top-2 right-0 bg-background text-primary text-xs font-bold px-2 py-1 rounded rounded-r-none shadow">
                            Stok: {{ $book->stok }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col grow">
                        <h3 class="font-bold text-primary text-lg leading-tight mb-1 line-clamp-2">{{ $book->judul }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $book->penulis }}</p>

                        <div class="mt-auto">
                            <a href="{{ route('book.show', $book->slug) }}"
                                class="w-full block text-center border-2 border-primary text-primary font-bold py-2 rounded-lg hover:bg-primary hover:text-white transition">
                                📖 Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-600">Buku tidak ditemukan</h3>
                    <p class="text-gray-400">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
            <div class="mt-8">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
