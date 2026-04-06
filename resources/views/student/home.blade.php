@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="space-y-8">

        <form action="{{ route('student.katalog') }}" method="GET">
            <div class="flex rounded-lg overflow-hidden border border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-primary/40">
                <input type="text" name="search"
                    class="w-full text-gray-800 px-4 py-2.5 text-sm focus:outline-none bg-white"
                    placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">
                <button type="submit"
                    class="bg-primary text-white px-6 py-2.5 text-sm font-semibold hover:bg-primary/90 transition shrink-0">
                    Cari
                </button>
            </div>
        </form>

        {{-- Buku Terpopuler: Horizontal Scroll --}}
        <div>
            <div class="flex items-center gap-2 mb-4">
                <h2 class="text-xl font-bold text-text">Terpopuler</h2>
                <span class="text-lg">🔥</span>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                @foreach ($popularBooks as $NB)
                    <div class="shrink-0 w-[220px]">
                        <x-book-card :book="$NB" />
                    </div>
                @endforeach
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

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-5 gap-x-10">
            @forelse ($books as $book)
                <x-book-card :book="$book" />



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



    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
    </style>
@endsection
