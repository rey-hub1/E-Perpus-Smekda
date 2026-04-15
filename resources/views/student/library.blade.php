@extends('layouts.app')

@section('title', 'Library Saya')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold font-heading text-text">Library Saya</h1>
                <p class="text-sm text-text/50 mt-1">Koleksi buku yang kamu tandai secara pribadi.</p>
            </div>

            
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <div class="bg-background border border-text/10 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 text-center min-w-16">
                    <p class="text-lg sm:text-xl font-black text-text">{{ $library->count() }}</p>
                    <p class="text-[10px] sm:text-[11px] font-medium text-text/40 mt-0.5">Total Tersimpan</p>
                </div>
            </div>
        </div>

        
        @if (session('success'))
            <div class="bg-accent/10 border border-accent/20 text-accent px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        

        
        <div class="space-y-3" id="bookList">
            @forelse ($library as $entry)
                <div class="lib-item bg-background rounded-xl border border-text/5 hover:border-text/10 hover:shadow-sm transition-all duration-200 overflow-hidden"
                     data-status="{{ $entry->status }}">
                    <div class="flex flex-col sm:flex-row">

                        
                        <a href="{{ route('book.show', $entry->book->slug) }}"
                            class="shrink-0 flex items-center justify-center bg-text/2 px-4 sm:px-5 py-4 sm:py-5 group sm:min-w-[100px]">
                            <div class="[perspective:700px]">
                                <div class="relative w-[60px] h-[84px] sm:w-[68px] sm:h-[96px] [transform-style:preserve-3d] [-webkit-transform:rotateY(-16deg)_rotateX(2deg)] transition-transform duration-400 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] group-hover:[-webkit-transform:rotateY(-22deg)_rotateX(3deg)_scale(1.05)]">
                                    <div class="absolute inset-0 bg-white rounded-l-[1px] rounded-r-[6px] [transform:translateZ(-8px)_translateX(8px)] shadow-[3px_5px_12px_rgba(0,0,0,0.18)] z-1"></div>
                                    <div class="absolute top-[3px] right-0 bottom-[3px] left-[1px] bg-[#f5f5f0] border border-text/10 rounded-l-[1px] rounded-r-[5px] [transform:translateZ(-4px)_translateX(5px)] z-5
                                        before:content-[''] before:absolute before:inset-0 before:bg-[repeating-linear-gradient(to_right,transparent,transparent_1px,rgba(0,0,0,0.03)_1.5px,transparent_2.5px)]"></div>
                                    <div class="absolute inset-0 rounded-l-[1px] rounded-r-[6px] overflow-hidden bg-background shadow-[0_4px_12px_rgba(0,0,0,0.15)] z-10">
                                        @if ($entry->book->cover_url)
                                            <img src="{{ $entry->book->cover_url }}" alt="{{ $entry->book->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center p-2 bg-gradient-to-br from-gray-600 to-gray-800">
                                                <p class="text-white/90 text-center font-bold text-[9px] leading-tight">{{ $entry->book->judul }}</p>
                                            </div>
                                        @endif
                                        <div class="absolute inset-y-0 left-0 w-2.5 bg-gradient-to-r from-black/30 to-transparent pointer-events-none"></div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        
                        <div class="flex-1 px-4 sm:px-5 py-3 sm:py-4 flex flex-col gap-3 sm:gap-4 min-w-0">

                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start sm:items-center gap-2 mb-1 flex-wrap">
                                    <a href="{{ route('book.show', $entry->book->slug) }}"
                                       class="font-bold text-text text-sm sm:text-base leading-tight hover:text-primary transition-colors line-clamp-2 sm:line-clamp-1">
                                        {{ $entry->book->judul }}
                                    </a>
                                    <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-full bg-cta text-text/70">
                                        Tersimpan
                                    </span>
                                </div>

                                <p class="text-xs sm:text-sm text-text/40 mb-2 sm:mb-3">{{ $entry->book->penulis }}</p>

                                <div class="flex flex-wrap gap-x-3 sm:gap-x-4 gap-y-1 text-xs text-text/40">
                                    @if ($entry->book->category)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
                                            </svg>
                                            <span>{{ $entry->book->category->name }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <span>Ditambahkan {{ $entry->created_at->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="flex items-center gap-2 pt-1 sm:pt-0 border-t border-text/5 sm:border-t-0">
                                

                                
                                <form action="{{ route('library.destroy', $entry->book) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku ini dari library?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-text/30 hover:text-secondary hover:bg-secondary/10 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 sm:py-20 bg-background rounded-xl border border-dashed border-text/10">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 sm:w-14 h-12 sm:h-14 text-text/10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-text/50">Library masih kosong</h3>
                    <p class="text-sm text-text/40 mt-1">Tandai buku dari halaman detail buku.</p>
                    <a href="{{ route('student.home') }}"
                               class="mt-5 inline-flex items-center gap-2 bg-primary text-background font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-secondary transition shadow-sm">
                        Jelajah Buku
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        <div id="emptyTab" class="hidden text-center py-12">
            <p class="text-sm text-text/40 font-medium">Tidak ada buku di kategori ini.</p>
        </div>

    </div>


@endsection
