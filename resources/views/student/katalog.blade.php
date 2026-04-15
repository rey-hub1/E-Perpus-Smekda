@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
    <div class="space-y-5">

        
        @if (session('success'))
            <div class="bg-accent/10 border-l-4 border-accent text-accent px-4 py-4 rounded shadow ">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-primary/10 border-l-4 border-primary text-secondary px-4 py-4 rounded shadow ">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        
        <form action="{{ route('student.katalog') }}" method="GET">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="flex rounded-lg overflow-hidden border border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-primary/40">
                <input type="text" name="search"
                    class="w-full text-gray-800 px-4 py-2.5 text-sm focus:outline-none bg-white"
                    placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                <button type="submit"
                    class="bg-primary text-white px-5 py-2.5 text-sm font-semibold hover:bg-primary/90 transition shrink-0">
                    Cari
                </button>
            </div>
        </form>

        
        <div class="flex gap-2 overflow-x-auto scrollbar-hide flex-nowrap py-0.5 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('student.katalog', array_filter(['search' => request('search')])) }}"
                class="shrink-0 px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-semibold border transition whitespace-nowrap
                    {{ !request('category') ? 'bg-primary text-white border-primary shadow' : 'bg-white text-gray-600 border-gray-300 hover:border-primary hover:text-primary' }}">
                Semua
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('student.katalog', array_filter(['search' => request('search'), 'category' => $cat->id])) }}"
                    class="shrink-0 px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-semibold border transition whitespace-nowrap
                        {{ request('category') == $cat->id ? 'bg-primary text-white border-primary shadow' : 'bg-white text-gray-600 border-gray-300 hover:border-primary hover:text-primary' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        
        @if (request('search') || request('category'))
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <p class="text-gray-500 text-sm">
                    Menampilkan
                    <span class="font-bold text-primary">{{ $books->total() }}</span> buku
                    @if (request('search'))
                        untuk <span class="font-bold text-primary">"{{ request('search') }}"</span>
                    @endif
                    @if (request('category'))
                        @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
                        @if ($activeCat)
                            dalam <span class="font-bold text-primary">{{ $activeCat->name }}</span>
                        @endif
                    @endif
                </p>
                <a href="{{ route('student.katalog') }}" class="text-primary text-sm hover:underline font-semibold self-start sm:self-auto">
                    Reset Filter
                </a>
            </div>
        @endif

        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
            @forelse ($books as $book)
                <x-book-card :book="$book" />
            @empty
                <div class="col-span-full text-center py-16 sm:py-20 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 sm:w-16 h-12 sm:h-16 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-text/60">Buku tidak ditemukan</h3>
                    <p class="text-text/40 text-sm mt-1">Coba kata kunci lain atau pilih kategori berbeda.</p>
                    <a href="{{ route('student.katalog') }}"
                        class="mt-4 inline-block text-primary font-semibold hover:underline text-sm">
                        Tampilkan semua buku &rarr;
                    </a>
                </div>
            @endforelse
        </div>

        
        @if ($books->hasPages())
            <div class="bg-white border border-gray-200 rounded-xl px-5 py-4">
                {{ $books->links() }}
            </div>
        @endif

    </div>

@endsection
