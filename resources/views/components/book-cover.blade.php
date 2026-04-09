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
        /* Serong sedikit banget sebelum di hover */
        transform: rotateY(-2deg);
    }
    .group:hover .book-3d {
        /* Saat dihover serongnya juga tidak terlalu ekstrem */
        transform: rotateY(-8deg) scale(1.02) translateX(-2px);
    }
    .book-pages {
        position: absolute;
        inset: 4px 2px 4px 0;
        background-color: var(--color-background);
        border: 1px solid var(--color-text);
        border-color: color-mix(in srgb, var(--color-text) 10%, transparent);
        border-radius: 2px 8px 8px 2px;
        transform: translateZ(-5px) translateX(0);
        box-shadow: inset 4px 0 10px rgba(0,0,0,0.05);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        opacity: 1; /* Always show slightly */
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
        /* Ganti dengan plain color (putih bersih dengan border) */
        background: var(--color-background);
        border: 1px solid var(--color-text);
        border-color: color-mix(in srgb, var(--color-text) 10%, transparent);
        border-radius: 2px 10px 10px 2px;
        transform: translateZ(-8px) translateX(0);
        box-shadow: 2px 2px 5px rgba(0,0,0,0.05);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        opacity: 1; /* Always show slightly */
        z-index: -2;
    }
    .group:hover .book-pages {
        transform: translateZ(-5px) translateX(5px);
    }
    .group:hover .book-back {
        transform: translateZ(-8px) translateX(9px);
        box-shadow: 4px 4px 10px rgba(0,0,0,0.1);
    }
</style>
@endonce

<a href="{{ route('book.show', $book->slug) }}" class="group block">
    <div class="book-wrapper mx-auto {{ $large ? 'w-[200px] h-[285px] sm:w-[220px] sm:h-[315px] md:w-[240px] md:h-[340px]' : 'w-[140px] h-[200px] sm:w-[150px] sm:h-[215px] md:w-[160px] md:h-[230px]' }}">
        <div class="book-3d relative w-full h-full rounded-l-[3px] rounded-r-lg shadow-lg">
            <div class="book-back"></div>
            <div class="book-pages"></div>

            <div class="absolute inset-0 rounded-l-[3px] rounded-r-lg overflow-hidden z-10 bg-text/10">
                @if ($book->gambar)
                    <img src="{{ $book->cover_url }}" class="w-full h-full object-cover" alt="{{ $book->judul }}">
                @else
                    <div class="w-full h-full flex items-center justify-center p-3 bg-gradient-to-br from-text/70 to-text">
                        <p class="text-white text-center font-bold text-xs leading-tight">{{ $book->judul }}</p>
                    </div>
                @endif

                <!-- Spine binding shadow -->
                <div class="absolute inset-y-0 left-0 w-6 bg-gradient-to-r from-black/50 via-black/15 to-transparent pointer-events-none"></div>
                <!-- Spine outer edge highlight -->
                <div class="absolute inset-y-0 left-0 w-[2px] bg-gradient-to-b from-white/50 via-white/30 to-white/10 pointer-events-none"></div>
                <!-- Spine inner crease -->
                <div class="absolute inset-y-0 left-[3px] w-[1.5px] bg-black/20 pointer-events-none"></div>
                <!-- Spine soft shadow band -->
                <div class="absolute inset-y-0 left-[5px] w-[6px] bg-gradient-to-r from-black/10 to-transparent pointer-events-none"></div>
                <!-- Gloss sheen -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/15 via-white/5 to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
</a>
