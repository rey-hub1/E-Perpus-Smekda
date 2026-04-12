@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
    <div class="space-y-6">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="bg-accent/10 border-l-4 border-accent text-accent px-4 py-4 rounded shadow animate-fade-in-up">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-primary/10 border-l-4 border-primary text-secondary px-4 py-4 rounded shadow animate-fade-in-up">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Search + Filter --}}
        <div class="flex items-center gap-3">
            {{-- Filter Kategori (overflow scroll) --}}
            <div class="flex gap-2 overflow-x-auto scrollbar-hide flex-nowrap py-1 flex-1">
                <a href="{{ route('student.katalog', array_filter(['search' => request('search')])) }}"
                    class="shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold border transition whitespace-nowrap
                        {{ !request('category') ? 'bg-primary text-white border-primary shadow' : 'bg-white text-gray-600 border-gray-300 hover:border-primary hover:text-primary' }}">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('student.katalog', array_filter(['search' => request('search'), 'category' => $cat->id])) }}"
                        class="shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold border transition whitespace-nowrap
                            {{ request('category') == $cat->id ? 'bg-primary text-white border-primary shadow' : 'bg-white text-gray-600 border-gray-300 hover:border-primary hover:text-primary' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Search --}}
            <form action="{{ route('student.katalog') }}" method="GET" class="shrink-0">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="flex rounded-lg overflow-hidden border border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-primary/40">
                    <input type="text" name="search"
                        class="w-52 md:w-64 text-gray-800 px-4 py-2 text-sm focus:outline-none bg-white"
                        placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                    <button type="submit"
                        class="bg-primary text-white px-4 py-2 text-sm font-semibold hover:bg-primary/90 transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Info pencarian/filter aktif --}}
        @if (request('search') || request('category'))
            <div class="flex justify-between items-center px-1">
                <p class="text-gray-500 text-sm">
                    Menampilkan
                    <span class="font-bold text-primary">{{ $books->total() }}</span> buku
                    @if (request('search'))
                        untuk pencarian <span class="font-bold text-primary">"{{ request('search') }}"</span>
                    @endif
                    @if (request('category'))
                        @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
                        @if ($activeCat)
                            dalam kategori <span class="font-bold text-primary">{{ $activeCat->name }}</span>
                        @endif
                    @endif
                </p>
                <a href="{{ route('student.katalog') }}" class="text-primary text-sm hover:underline font-semibold">
                    Reset Filter
                </a>
            </div>
        @endif

        {{-- Grid Buku --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse ($books as $book)
                <x-book-card :book="$book" />
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-text/60">Buku tidak ditemukan</h3>
                    <p class="text-text/40">Coba kata kunci lain atau pilih kategori berbeda.</p>
                    <a href="{{ route('student.katalog') }}"
                        class="mt-4 inline-block text-primary font-semibold hover:underline text-sm">
                        Tampilkan semua buku &rarr;
                    </a>
                </div>
            @endforelse
        </div>


    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endsection
