@props(['book', 'large' => false])

@once
<style>
    .book-wrapper {
        perspective: 1000px;
    }
    .book-3d {
        transform-style: preserve-3d;
        transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        transform-origin: left center;
    }
    .group:hover .book-3d {
        transform: rotateY(-15deg) rotateX(2deg) scale(1.05) translateX(-5px);
    }
    .book-pages {
        position: absolute;
        inset: 4px 2px 4px 0;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 2px 8px 8px 2px;
        transform: translateZ(-5px) translateX(0);
        box-shadow: inset 4px 0 10px rgba(0,0,0,0.05);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        opacity: 0;
        z-index: -1;
    }
    .book-pages::before {
        content: '';
        position: absolute;
        top: 0; right: 2px; bottom: 0; left: 0;
        background: repeating-linear-gradient(to right, transparent, transparent 1px, rgba(0,0,0,0.04) 2px, transparent 3px);
    }
    .book-back {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, #374151 0%, #1f2937 100%);
        border-radius: 2px 10px 10px 2px;
        transform: translateZ(-10px) translateX(0);
        box-shadow: 3px 3px 8px rgba(0,0,0,0.08);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        opacity: 0;
        z-index: -2;
    }
    .group:hover .book-pages {
        transform: translateZ(-5px) translateX(6px);
        opacity: 1;
    }
    .group:hover .book-back {
        transform: translateZ(-10px) translateX(9px);
        box-shadow: 8px 8px 18px rgba(0,0,0,0.18);
        opacity: 0.85;
    }
</style>
@endonce

<a href="{{ route('book.show', $book->slug) }}" class="group block">
    <div class="book-wrapper mx-auto {{ $large ? 'w-[200px] h-[285px] sm:w-[220px] sm:h-[315px] md:w-[240px] md:h-[340px]' : 'w-[140px] h-[200px] sm:w-[150px] sm:h-[215px] md:w-[160px] md:h-[230px]' }}">
        <div class="book-3d relative w-full h-full rounded-l-[3px] rounded-r-xl shadow-lg">
            <div class="book-back"></div>
            <div class="book-pages"></div>

            <div class="absolute inset-0 rounded-l-[3px] rounded-r-xl overflow-hidden z-10 bg-gray-300">
                @if ($book->gambar)
                    <img src="{{ $book->cover_url }}" class="w-full h-full object-cover" alt="{{ $book->judul }}">
                @else
                    <div class="w-full h-full flex items-center justify-center p-3 bg-gradient-to-br from-gray-700 to-gray-900">
                        <p class="text-white text-center font-bold text-xs leading-tight">{{ $book->judul }}</p>
                    </div>
                @endif

                <div class="absolute inset-y-0 left-0 w-3 bg-gradient-to-r from-black/30 to-transparent pointer-events-none"></div>
                <div class="absolute inset-y-0 left-0 w-[1.5px] bg-white/20 pointer-events-none"></div>
                <div class="absolute inset-y-0 left-[4px] w-[1px] bg-black/15 pointer-events-none"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/15 pointer-events-none"></div>
            </div>
        </div>
    </div>
</a>
