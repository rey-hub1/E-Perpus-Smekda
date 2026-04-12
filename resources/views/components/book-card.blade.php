@props(['book'])

@once
<style>
    /* 3D Book Variables & Perspective */
    .book-wrapper {
        perspective: 1000px;
    }

    /* The book container that rotates */
    .book-3d {
        transform-style: preserve-3d;
        transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        transform-origin: left center;
        /* Serong sedikit banget sebelum di hover */
        transform: rotateY(-2deg);
    }

    /* Hover Effect */
    .group:hover .book-3d {
        /* Saat dihover serongnya juga tidak terlalu ekstrem */
        transform: rotateY(-15deg) scale(1.02) translateX(-2px);
    }

    /* White pages on the right edge */
    .book-pages {
        position: absolute;
        inset: 4px 2px 4px 0; /* Align with cover initially */
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 2px 8px 8px 2px;
        /* perfectly aligned behind cover */
        transform: translateZ(-5px) translateX(0);
        box-shadow: inset 4px 0 10px rgba(0,0,0,0.05);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        opacity: 1; /* Always show slightly */
        z-index: -1;
    }

    /* Lines to simulate individual pages */
    .book-pages::before {
        content: '';
        position: absolute;
        top: 0; right: 2px; bottom: 0; left: 0;
        background: repeating-linear-gradient(to right, transparent, transparent 1px, rgba(0,0,0,0.04) 2px, transparent 3px);
    }

    /* Back Cover of the book */
    .book-back {
        position: absolute;
        inset: 0;
        /* Ganti dengan plain color putih dengan border */
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 2px 10px 10px 2px;
        transform: translateZ(-8px) translateX(0);
        box-shadow: 2px 2px 5px rgba(0,0,0,0.05);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        opacity: 1; /* Always show slightly */
        z-index: -2;
    }

    /* Animation on hover: Slide out to the RIGHT */
    .group:hover .book-pages {
        transform: translateZ(-5px) translateX(5px);
    }

    .group:hover .book-back {
        transform: translateZ(-8px) translateX(9px);
        box-shadow: 4px 4px 10px rgba(0,0,0,0.1);
    }
</style>
@endonce

<a href="{{ route('book.show', $book->slug) }}" class="group block flex flex-col h-full bg-background rounded-xl overflow-hidden  transition-all duration-300 border border-gray-100">

    <!-- Top Area: Gray background box with Book -->
    <div class="relative bg-gray-100 p-4 pt-12 pb-12 flex justify-center items-center rounded-t-xl overflow-hidden">

        <!-- Badges (Category & Status) -->
        <div class="absolute top-4 left-4 right-4 flex justify-between items-center z-20">
            <span class="text-[10px] font-semibold text-text/50 tracking-wide truncate max-w-full">{{ $book->category->name ?? '' }}</span>
        </div>

        <!-- The 3D Book Container -->
        <div class="book-wrapper w-[110px] h-[155px] sm:w-[120px] sm:h-[170px] md:w-[130px] md:h-[185px]">
            <div class="book-3d relative w-full h-full rounded-l-[3px] rounded-r-lg shadow-lg">
                <!-- Layers (Bottom-most to Top-most) -->
                <div class="book-back"></div>
                <div class="book-pages"></div>

                <!-- Front Cover -->
                <div class="absolute inset-0 rounded-l-[3px] rounded-r-lg overflow-hidden z-10 bg-gray-300">
                    @if ($book->gambar)
                        <img src="{{ $book->cover_url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-sm font-bold text-gray-500">
                            No Cover
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
    </div>

    <!-- Bottom Info Area -->
    <div class="px-3.5 py-3 flex flex-col grow justify-between">

        <div>
            <span class="text-[10px] font-semibold text-text/40 uppercase tracking-wide truncate block mb-1">{{ $book->category->name ?? '' }}</span>
            <h3 class="font-bold text-text text-sm leading-tight truncate mb-1">{{ $book->judul }}</h3>
            <p class="text-xs text-gray-500 truncate">{{ $book->penulis }}</p>
        </div>

        <div class="mt-2 flex items-center justify-between">
            <div class="flex items-center gap-0.5 text-yellow-400">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                <span class="text-[11px] text-gray-500 font-medium">4.0</span>
            </div>
            @if($book->stok > 0)
                <span class="text-[11px] font-semibold text-accent">{{ $book->stok }} tersedia</span>
            @else
                <span class="text-[11px] font-semibold text-primary">Habis</span>
            @endif
        </div>

    </div>
</a>
