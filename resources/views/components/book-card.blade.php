@props(['book'])

<a href="{{ route('book.show', $book->slug) }}" class="group block flex flex-col h-full bg-background rounded-xl overflow-hidden border border-gray-100">

    <div class="relative bg-gray-100 p-4 pt-12 pb-12 flex justify-center items-center rounded-t-xl overflow-hidden">
        <div class="absolute top-4 left-4 right-4 flex justify-between items-center z-20">
            <span class="text-[10px] font-semibold text-text/50 tracking-wide truncate max-w-full">{{ $book->category->name ?? '' }}</span>
        </div>

        <div class="[perspective:1000px] w-[110px] h-[155px] sm:w-[120px] sm:h-[170px] md:w-[130px] md:h-[185px]">
            <div class="[transform-style:preserve-3d] transition-transform duration-500 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] origin-left [-webkit-transform:rotateY(-2deg)] group-hover:[-webkit-transform:rotateY(-15deg)_scale(1.02)_translateX(-2px)] relative w-full h-full rounded-l-[3px] rounded-r-lg shadow-lg">
                
                <div class="absolute inset-0 bg-white border border-gray-200 rounded-l-[2px] rounded-r-[10px] [transform:translateZ(-8px)] shadow-[2px_2px_5px_rgba(0,0,0,0.05)] transition-transform duration-600 [transition-timing-function:cubic-bezier(0.34,1.56,0.64,1)] z-[-2] group-hover:[transform:translateZ(-8px)_translateX(9px)] group-hover:shadow-[4px_4px_10px_rgba(0,0,0,0.1)]"></div>
                
                <div class="absolute inset-[4px_2px_4px_0] bg-gray-100 border border-gray-200 rounded-l-[2px] rounded-r-[8px] [transform:translateZ(-5px)] shadow-[inset_4px_0_10px_rgba(0,0,0,0.05)] transition-transform duration-600 [transition-timing-function:cubic-bezier(0.34,1.56,0.64,1)] z-[-1] group-hover:[transform:translateZ(-5px)_translateX(5px)]
                    before:content-[''] before:absolute before:inset-[0_2px_0_0] before:bg-[repeating-linear-gradient(to_right,transparent,transparent_1px,rgba(0,0,0,0.04)_2px,transparent_3px)]"></div>
                
                <div class="absolute inset-0 rounded-l-[3px] rounded-r-lg overflow-hidden z-10 bg-gray-300">
                    @if ($book->gambar)
                        <img src="{{ $book->cover_url }}" class="w-full h-full object-cover" alt="{{ $book->judul }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-sm font-bold text-gray-500">No Cover</div>
                    @endif
                    <div class="absolute inset-y-0 left-0 w-6 bg-gradient-to-r from-black/50 via-black/15 to-transparent pointer-events-none"></div>
                    <div class="absolute inset-y-0 left-0 w-[2px] bg-gradient-to-b from-white/50 via-white/30 to-white/10 pointer-events-none"></div>
                    <div class="absolute inset-y-0 left-[3px] w-[1.5px] bg-black/20 pointer-events-none"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-white/15 via-white/5 to-transparent pointer-events-none"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-3.5 py-3 flex flex-col grow justify-between">
        <div>
            <span class="text-[10px] font-semibold text-text/40 uppercase tracking-wide truncate block mb-1">{{ $book->category->name ?? '' }}</span>
            <h3 class="font-bold text-text text-sm leading-tight truncate mb-1">{{ $book->judul }}</h3>
            <p class="text-xs text-gray-500 truncate">{{ $book->penulis }}</p>
        </div>
        <div class="mt-2 flex items-center justify-end">
            @if($book->stok > 0)
                <span class="text-[11px] font-semibold text-accent">{{ $book->stok }} tersedia</span>
            @else
                <span class="text-[11px] font-semibold text-primary">Habis</span>
            @endif
        </div>
    </div>
</a>
