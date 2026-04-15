@extends('layouts.app')

@section('title', 'Beranda')
@section('content-padding', '') {{-- Kelola padding manual per-section --}}

@section('content')
    <div class="space-y-6 sm:space-y-8">

        {{-- Search Bar --}}
        <div class="px-4 sm:px-6 lg:px-8">
            <form action="{{ route('student.katalog') }}" method="GET">
                <div class="flex rounded-lg overflow-hidden border border-text/10 shadow-sm focus-within:ring-2 focus-within:ring-primary/40">
                    <input type="text" name="search"
                        class="w-full text-text px-4 py-2.5 text-sm focus:outline-none bg-background"
                        placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">
                    <button type="submit"
                        class="bg-primary text-background px-5 py-2.5 text-sm font-semibold hover:bg-secondary transition shrink-0">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Rekomendasi (Featured) --}}
        <div>
            <div class="flex items-center gap-2 mb-4 px-4 sm:px-6 lg:px-8">
                <h2 class="text-lg sm:text-xl font-bold text-text">Rekomendasi</h2>
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                </svg>
            </div>

            <div class="flex gap-3 sm:gap-4 overflow-x-auto pb-3 scrollbar-hide pl-4 sm:pl-6 lg:pl-8 pr-4 snap-x snap-proximity scroll-pl-4 sm:scroll-pl-6 lg:scroll-pl-8 lg:grid lg:grid-cols-5 lg:overflow-x-visible lg:pb-0 lg:px-8">
                @foreach ($popularBooks as $NB)
                    <div class="shrink-0 w-[160px] sm:w-[200px] md:w-[220px] snap-start lg:w-auto lg:shrink">
                        <x-book-card :book="$NB" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kategori --}}
        @if ($categories->isNotEmpty())
        @php
            $catPalette = [
                ['bg' => '#FEE2E2', 'accent' => '#DC2626', 'dot' => '#FCA5A5'],
                ['bg' => '#FEF3C7', 'accent' => '#D97706', 'dot' => '#FCD34D'],
                ['bg' => '#D1FAE5', 'accent' => '#059669', 'dot' => '#6EE7B7'],
                ['bg' => '#DBEAFE', 'accent' => '#2563EB', 'dot' => '#93C5FD'],
                ['bg' => '#EDE9FE', 'accent' => '#7C3AED', 'dot' => '#C4B5FD'],
                ['bg' => '#FFEDD5', 'accent' => '#EA580C', 'dot' => '#FDBA74'],
                ['bg' => '#CCFBF1', 'accent' => '#0D9488', 'dot' => '#5EEAD4'],
                ['bg' => '#FCE7F3', 'accent' => '#DB2777', 'dot' => '#F9A8D4'],
            ];
        @endphp
        <div>
            <div class="flex items-center justify-between mb-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg sm:text-xl font-bold text-text">Kategori</h2>
                    <svg class="w-5 h-5 text-text/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                    </svg>
                </div>
                <a href="{{ route('student.katalog') }}" class="text-xs font-semibold text-text/40 hover:text-primary transition-colors">
                    Semua buku &rarr;
                </a>
            </div>

            <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2 scrollbar-hide pl-4 sm:pl-6 lg:pl-8 pr-4 snap-x snap-proximity scroll-pl-4 sm:scroll-pl-6 lg:scroll-pl-8">
                @foreach ($categories as $cat)
                    @php $p = $catPalette[$loop->index % count($catPalette)]; @endphp
                    <a href="{{ route('student.katalog', ['category' => $cat->id]) }}"
                        class="cat-card shrink-0 snap-start flex flex-col justify-between rounded-2xl px-3 sm:px-4 py-3 sm:py-4 w-32 sm:w-40 min-h-24 sm:min-h-28 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg"
                        style="background: {{ $p['bg'] }};">
                        <div class="flex items-start justify-between">
                            <div class="w-8 sm:w-9 h-8 sm:h-9 rounded-xl flex items-center justify-center" style="background: {{ $p['accent'] }}20;">
                                <x-category-icon :name="$cat->icon ?? 'book-open'" class="w-4 sm:w-5 h-4 sm:h-5" style="color: {{ $p['accent'] }};" />
                            </div>
                            <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 opacity-30 mt-1" style="color: {{ $p['accent'] }};" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>

                        <div class="mt-2 sm:mt-3">
                            <p class="font-bold text-xs sm:text-sm leading-tight" style="color: {{ $p['accent'] }}; font-family: var(--font-heading);">{{ $cat->name }}</p>
                            <p class="text-[10px] sm:text-xs mt-0.5 font-medium" style="color: {{ $p['accent'] }}; opacity: 0.6;">{{ $cat->books_count }} buku</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Koleksi --}}
        <div class="px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
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

            @if (request('search'))
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <p class="text-text/50 text-sm">Hasil pencarian: <span class="font-bold text-primary">"{{ request('search') }}"</span></p>
                    <a href="{{ route('student.home') }}" class="text-primary text-sm hover:underline font-semibold self-start sm:self-auto">Reset / Tampilkan Semua</a>
                </div>
            @endif

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg sm:text-xl font-bold text-text">Koleksi</h2>
                    <svg class="w-5 h-5 text-text/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <a href="{{ route('student.katalog') }}" class="text-xs font-semibold text-text/40 hover:text-primary transition-colors flex items-center gap-1 group/all">
                    Lihat Semua
                    <svg class="w-4 h-4 transition-transform group-hover/all:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            <div class="-mx-4 sm:-mx-6 lg:-mx-8">
                <div class="flex gap-2 sm:gap-3 lg:gap-4 overflow-x-auto pb-6 sm:pb-8 scrollbar-hide px-4 sm:px-6 lg:px-8 snap-x snap-proximity lg:grid lg:grid-cols-5 lg:overflow-x-visible lg:pb-0">
                    @forelse ($books->take(5) as $book)
                        <div class="shrink-0 w-[160px] sm:w-[200px] md:w-[220px] snap-start lg:w-auto lg:shrink">
                            <x-book-card :book="$book" />
                        </div>
                    @empty
                        <div class="w-full text-center py-16 sm:py-20 bg-background rounded-xl border border-dashed border-text/10 col-span-full">
                            <div class="flex justify-center mb-4">
                                <svg class="w-12 sm:w-14 h-12 sm:h-14 text-text/10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-text/60">Buku tidak ditemukan</h3>
                            <p class="text-text/40 text-sm">Koleksi kami masih kosong atau tidak ada yang sesuai.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
    </style>
@endsection
