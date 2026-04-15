@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-col sm:flex-row items-center justify-between gap-3">

        {{-- Info halaman --}}
        <p class="text-xs text-gray-400 order-2 sm:order-1">
            Menampilkan
            <span class="font-semibold text-gray-600">{{ $paginator->firstItem() }}</span>
            &ndash;
            <span class="font-semibold text-gray-600">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-gray-600">{{ $paginator->total() }}</span>
            data
        </p>

        {{-- Tombol halaman --}}
        <div class="flex items-center gap-1 order-1 sm:order-2">

            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-gray-500 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                    </svg>
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($elements as $element)
                {{-- Ellipsis --}}
                @if (is_string($element))
                    <span class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 select-none">
                        &hellip;
                    </span>
                @endif

                {{-- Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-bold bg-primary text-white shadow-sm cursor-default">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-gray-500 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </span>
            @endif

        </div>
    </nav>
@endif
