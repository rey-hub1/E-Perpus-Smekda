@props(['book', 'large' => false])

<a href="{{ route('book.show', $book->slug) }}" class="group block">
    <div class="[perspective:1000px] mx-auto {{ $large ? 'w-[150px] h-[215px] sm:w-[200px] sm:h-[285px] md:w-[220px] md:h-[315px] lg:w-[240px] lg:h-[340px]' : 'w-[120px] h-[170px] sm:w-[140px] sm:h-[200px] md:w-[160px] md:h-[230px]' }}">
        <div class="[transform-style:preserve-3d] transition-transform duration-500 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] origin-left [-webkit-transform:rotateY(-2deg)] group-hover:[-webkit-transform:rotateY(-8deg)_scale(1.02)_translateX(-2px)] relative w-full h-full rounded-l-[3px] rounded-r-lg shadow-lg">
            
            <div class="absolute inset-0 bg-background border border-text/10 rounded-l-[2px] rounded-r-[10px] [transform:translateZ(-8px)] shadow-[2px_2px_5px_rgba(0,0,0,0.05)] transition-all duration-500 [transition-timing-function:cubic-bezier(0.34,1.56,0.64,1)] z-[-2] group-hover:[transform:translateZ(-8px)_translateX(9px)] group-hover:shadow-[4px_4px_10px_rgba(0,0,0,0.1)]"></div>
            
            <div class="absolute inset-[4px_2px_4px_0] bg-background border border-text/10 rounded-l-[2px] rounded-r-[8px] [transform:translateZ(-5px)] shadow-[inset_4px_0_10px_rgba(0,0,0,0.05)] transition-transform duration-600 [transition-timing-function:cubic-bezier(0.34,1.56,0.64,1)] z-[-1] group-hover:[transform:translateZ(-5px)_translateX(5px)]
                before:content-[''] before:absolute before:inset-[0_2px_0_0] before:bg-[repeating-linear-gradient(to_right,transparent,transparent_1px,rgba(0,0,0,0.04)_2px,transparent_3px)]"></div>
            
            <div class="absolute inset-0 rounded-l-[3px] rounded-r-lg overflow-hidden z-10 bg-text/10">
                @if ($book->gambar)
                    <img src="{{ $book->cover_url }}" class="w-full h-full object-cover" alt="{{ $book->judul }}">
                @else
                    <div class="w-full h-full flex items-center justify-center p-3 bg-gradient-to-br from-text/70 to-text">
                        <p class="text-white text-center font-bold text-xs leading-tight">{{ $book->judul }}</p>
                    </div>
                @endif
                <div class="absolute inset-y-0 left-0 w-6 bg-gradient-to-r from-black/50 via-black/15 to-transparent pointer-events-none"></div>
                <div class="absolute inset-y-0 left-0 w-[2px] bg-gradient-to-b from-white/50 via-white/30 to-white/10 pointer-events-none"></div>
                <div class="absolute inset-y-0 left-[3px] w-[1.5px] bg-black/20 pointer-events-none"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/15 via-white/5 to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
</a>
