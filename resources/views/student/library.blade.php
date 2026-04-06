@extends('layouts.app')

@section('title', 'Library Saya')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-text">Library Saya</h1>
                <p class="text-sm text-text/50 mt-1">Koleksi buku yang kamu tandai secara pribadi.</p>
            </div>

            {{-- Stats --}}
            <div class="flex gap-3">
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-center min-w-[72px]">
                    <p class="text-xl font-black text-text">{{ $reading->count() }}</p>
                    <p class="text-[11px] font-medium text-text/40 mt-0.5">Dibaca</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-center min-w-[72px]">
                    <p class="text-xl font-black text-text">{{ $saved->count() }}</p>
                    <p class="text-[11px] font-medium text-text/40 mt-0.5">Tersimpan</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-center min-w-[72px]">
                    <p class="text-xl font-black text-text">{{ $finished->count() }}</p>
                    <p class="text-[11px] font-medium text-text/40 mt-0.5">Selesai</p>
                </div>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tab Filter --}}
        <div class="flex gap-1 bg-gray-100 p-1 rounded-xl w-fit">
            <button onclick="switchTab('semua')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all bg-white text-text shadow-sm"
                data-tab="semua">
                Semua ({{ $library->count() }})
            </button>
            <button onclick="switchTab('reading')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all text-text/50"
                data-tab="reading">
                Sedang Dibaca ({{ $reading->count() }})
            </button>
            <button onclick="switchTab('saved')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all text-text/50"
                data-tab="saved">
                Tersimpan ({{ $saved->count() }})
            </button>
            <button onclick="switchTab('finished')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all text-text/50"
                data-tab="finished">
                Selesai ({{ $finished->count() }})
            </button>
        </div>

        {{-- Book List --}}
        <div class="space-y-3" id="bookList">
            @forelse ($library as $entry)
                <div class="lib-item bg-white rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all duration-200 overflow-hidden"
                     data-status="{{ $entry->status }}">
                    <div class="flex">

                        {{-- 3D Book Cover --}}
                        <a href="{{ route('book.show', $entry->book->slug) }}"
                            class="shrink-0 flex items-center justify-center bg-gray-100 px-5 py-5 group"
                            style="min-width: 110px;">
                            <div class="hist-book-perspective">
                                <div class="hist-book-3d">
                                    <div class="hist-book-back"></div>
                                    <div class="hist-book-pages"></div>
                                    <div class="hist-book-front">
                                        @if ($entry->book->gambar)
                                            <img src="{{ $entry->book->cover_url }}" alt="{{ $entry->book->judul }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center p-2 bg-gradient-to-br from-gray-600 to-gray-800">
                                                <p class="text-white text-center font-bold text-[9px] leading-tight">{{ $entry->book->judul }}</p>
                                            </div>
                                        @endif
                                        <div class="absolute inset-y-0 left-0 w-2.5 bg-gradient-to-r from-black/30 to-transparent pointer-events-none"></div>
                                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/10 pointer-events-none"></div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="flex-1 px-5 py-4 flex flex-col sm:flex-row sm:items-center gap-4 min-w-0">

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <a href="{{ route('book.show', $entry->book->slug) }}"
                                       class="font-bold text-text text-base leading-tight hover:text-primary transition-colors line-clamp-1">
                                        {{ $entry->book->judul }}
                                    </a>
                                    @php
                                        $badgeMap = [
                                            'reading'  => ['label' => 'Sedang Dibaca', 'class' => 'bg-blue-100 text-blue-600'],
                                            'saved'    => ['label' => 'Tersimpan',     'class' => 'bg-yellow-100 text-yellow-700'],
                                            'finished' => ['label' => 'Selesai',       'class' => 'bg-green-100 text-green-700'],
                                        ];
                                        $badge = $badgeMap[$entry->status];
                                    @endphp
                                    <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $badge['class'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </div>

                                <p class="text-sm text-text/40 mb-3">{{ $entry->book->penulis }}</p>

                                <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-text/40">
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

                            {{-- Actions --}}
                            <div class="shrink-0 flex items-center gap-2">
                                {{-- Update status --}}
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex items-center gap-1.5 text-xs font-semibold text-text/50 hover:text-text bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg transition-all hover:bg-gray-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                        </svg>
                                        Pindahkan
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.outside="open = false"
                                        class="absolute right-0 mt-1 w-44 bg-white rounded-xl border border-gray-100 shadow-lg z-20 overflow-hidden"
                                        x-transition>
                                        @foreach (['reading' => 'Sedang Dibaca', 'saved' => 'Tersimpan', 'finished' => 'Selesai Dibaca'] as $status => $label)
                                            @if ($entry->status !== $status)
                                                <form action="{{ route('library.store', $entry->book) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="{{ $status }}">
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm text-text/70 hover:bg-gray-50 hover:text-text transition-colors">
                                                        {{ $label }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Hapus --}}
                                <form action="{{ route('library.destroy', $entry->book) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku ini dari library?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-text/30 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
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
                <div class="text-center py-20 bg-white rounded-xl border border-dashed border-gray-200">
                    <div class="flex justify-center mb-4">
                        <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-text/50">Library masih kosong</h3>
                    <p class="text-sm text-text/40 mt-1">Tandai buku dari halaman detail buku.</p>
                    <a href="{{ route('student.home') }}"
                        class="mt-5 inline-flex items-center gap-2 bg-primary text-white font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-secondary transition shadow-sm">
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

    <style>
        .hist-book-perspective { perspective: 700px; }
        .hist-book-3d {
            width: 68px; height: 96px;
            position: relative;
            transform-style: preserve-3d;
            transform: rotateY(-16deg) rotateX(2deg);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .group:hover .hist-book-3d { transform: rotateY(-22deg) rotateX(3deg) scale(1.05); }
        .hist-book-front {
            position: absolute; inset: 0;
            border-radius: 1px 6px 6px 1px;
            overflow: hidden; z-index: 10;
            background: #d1d5db;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }
        .hist-book-pages {
            position: absolute; top: 3px; right: 0; bottom: 3px; left: 1px;
            background: #f5f5f0; border: 1px solid #e5e7eb;
            border-radius: 1px 5px 5px 1px;
            transform: translateZ(-4px) translateX(5px); z-index: 5;
        }
        .hist-book-pages::before {
            content: ''; position: absolute; inset: 0;
            background: repeating-linear-gradient(to right, transparent, transparent 1px, rgba(0,0,0,0.03) 1.5px, transparent 2.5px);
        }
        .hist-book-back {
            position: absolute; inset: 0;
            background: linear-gradient(160deg, #4b5563 0%, #1f2937 100%);
            border-radius: 1px 6px 6px 1px;
            transform: translateZ(-8px) translateX(8px);
            box-shadow: 3px 5px 12px rgba(0,0,0,0.18); z-index: 1;
        }
    </style>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-text', 'shadow-sm');
                btn.classList.add('text-text/50');
                if (btn.dataset.tab === tab) {
                    btn.classList.add('bg-white', 'text-text', 'shadow-sm');
                    btn.classList.remove('text-text/50');
                }
            });

            const items = document.querySelectorAll('.lib-item');
            let visibleCount = 0;
            items.forEach(item => {
                const show = tab === 'semua' || item.dataset.status === tab;
                item.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            document.getElementById('emptyTab').classList.toggle('hidden', visibleCount > 0 || items.length === 0);
        }

        switchTab('semua');
    </script>
@endsection
