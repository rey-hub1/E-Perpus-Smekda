@extends('layouts.app')

@section('title', 'Beranda')
@section('content-padding', '') {{-- Kelola padding manual per-section --}}

@section('content')
    <div class="space-y-8">

        <div class="px-8">
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
        </div>

        {{-- Rekomendasi (Featured): Full-width Horizontal Scroll --}}
        <div>
            <div class="flex items-center gap-2 mb-4 px-8">
                <h2 class="text-xl font-bold text-text">Rekomendasi</h2>
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                </svg>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-3 scrollbar-hide pl-8 pr-4 snap-x snap-proximity scroll-pl-8">
                @foreach ($popularBooks as $NB)
                    <div class="shrink-0 w-[300px] snap-start">
                        <x-book-card :book="$NB" />
                    </div>
                @endforeach
            </div>
        </div>

        <div class="px-8 space-y-8">
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
                <div class="flex justify-between items-center">
                    <p class="text-gray-500">Hasil pencarian: <span
                            class="font-bold text-primary">"{{ request('search') }}"</span></p>
                    <a href="{{ route('student.home') }}" class="text-red-500 text-sm hover:underline font-semibold">Reset
                        / Tampilkan Semua</a>
                </div>
            @endif

            <div class="flex items-center gap-2 mb-1">
                <h2 class="text-xl font-bold text-text">Koleksi</h2>
                <svg class="w-5 h-5 text-text/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-5 gap-x-10">
                @forelse ($books as $book)
                    <x-book-card :book="$book" />
                @empty
                    <div class="col-span-full text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                        <div class="flex justify-center mb-4">
                            <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-600">Buku tidak ditemukan</h3>
                        <p class="text-gray-400">Coba cari dengan kata kunci lain.</p>
                    </div>
                @endforelse
                <div class="mt-8">
                    {{ $books->withQueryString()->links() }}
                </div>
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
