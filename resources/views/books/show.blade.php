@extends('layouts.app')

@section('title', $book->judul)

@section('content')
    <div class="max-w-5xl mx-auto">

        <!-- Back Button -->
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 mb-8 text-sm font-medium text-text/50 hover:text-primary transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali
        </a>

        <!-- Main Content -->
        <div class="grid md:grid-cols-12 gap-10">

            <!-- Left: Book Display -->
            <div class="md:col-span-4">
                <div class="sticky top-8">

                    <!-- Book Display Area -->
                    <div class="show-book-area rounded-2xl flex flex-col justify-center items-center py-6 px-2 bg-gray-100" id="bookCoverArea">

                        <!-- Book with pages + back cover always visible -->
                        <div class="show-book-scene">
                            <div class="show-book-wrap">
                                <!-- Back Cover -->
                                <div class="show-back-cover" id="bookBackCover"></div>
                                <!-- Pages -->
                                <div class="show-pages"></div>
                                <!-- Front Cover -->
                                <div class="show-front-cover">
                                    @if ($book->gambar)
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}"
                                            class="w-full h-full object-cover book-cover-img" crossorigin="anonymous">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-700 to-gray-900 gap-3">
                                            <svg class="w-8 h-8 text-white/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                                            </svg>
                                            <p class="text-white text-center font-bold text-sm leading-snug">{{ $book->judul }}</p>
                                        </div>
                                    @endif
                                    <!-- Spine shadow -->
                                    <div class="absolute inset-y-0 left-0 w-5 bg-gradient-to-r from-black/30 to-transparent pointer-events-none rounded-l-sm"></div>
                                    <div class="absolute inset-y-0 left-0 w-[2px] bg-white/15 pointer-events-none"></div>
                                    <div class="absolute inset-y-0 left-[5px] w-[1px] bg-black/10 pointer-events-none"></div>
                                    <!-- Gloss -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-transparent pointer-events-none"></div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Favorite badge -->
                    @if ($book->favorite)
                        <div class="mt-4 flex items-center justify-center gap-1.5 text-sm text-accent font-semibold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Buku Favorit
                        </div>
                    @endif

                    <!-- Error -->
                    @if (session('error'))
                        <div class="mt-4 bg-primary/10 border border-primary/20 text-secondary text-sm font-medium px-4 py-3 rounded-xl text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Pinjam Button -->
                    <div class="mt-4">
                        @if($book->stok > 0)
                            <a href="{{ route('pinjam.jadwal', $book->id) }}"
                                class="w-full bg-primary hover:bg-secondary text-white font-bold text-base py-3.5 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/20 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                                Jadwalkan Peminjaman
                            </a>
                        @else
                            <button disabled
                                class="w-full bg-gray-200 text-gray-400 font-bold text-base py-3.5 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Stok Habis
                            </button>
                        @endif
                    </div>

                    <!-- Stok Info -->
                    <div class="mt-2.5 text-center">
                        @if($book->stok > 0)
                            <span class="text-xs text-text/40">Stok tersedia: <span class="font-semibold text-accent">{{ $book->stok }}</span> buku</span>
                        @else
                            <span class="text-xs font-semibold text-primary">Stok tidak tersedia saat ini</span>
                        @endif
                    </div>

                    <!-- Tambah ke Library -->
                    @php
                        $libraryEntry = \App\Models\UserLibrary::where('user_id', auth()->id())
                            ->where('book_id', $book->id)
                            ->first();
                        $libraryOptions = [
                            'reading'  => 'Sedang Dibaca',
                            'saved'    => 'Simpan ke Library',
                            'finished' => 'Tandai Selesai',
                        ];
                    @endphp
                    <div class="mt-3 relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between gap-2 px-4 py-3 rounded-xl border transition-all text-sm font-semibold
                                {{ $libraryEntry ? 'bg-primary/5 border-primary/20 text-primary hover:bg-primary/10' : 'bg-gray-50 border-gray-200 text-text/60 hover:bg-gray-100 hover:text-text' }}">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
                                </svg>
                                @if ($libraryEntry)
                                    {{ $libraryOptions[$libraryEntry->status] }}
                                @else
                                    Tambah ke Library
                                @endif
                            </div>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false"
                            class="absolute left-0 right-0 mt-1 bg-white rounded-xl border border-gray-100 shadow-lg z-30 overflow-hidden"
                            x-transition>
                            @foreach ($libraryOptions as $status => $label)
                                @if (!$libraryEntry || $libraryEntry->status !== $status)
                                    <form action="{{ route('library.store', $book) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ $status }}">
                                        <button type="submit"
                                            class="w-full text-left px-4 py-3 text-sm text-text/70 hover:bg-gray-50 hover:text-text transition-colors flex items-center gap-2">
                                            @if ($status === 'reading')
                                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                                            @elseif ($status === 'saved')
                                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/></svg>
                                            @else
                                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                            @endif
                                            {{ $label }}
                                        </button>
                                    </form>
                                @endif
                            @endforeach
                            @if ($libraryEntry)
                                <form action="{{ route('library.destroy', $book) }}" method="POST"
                                      class="border-t border-gray-100">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-sm text-red-400 hover:bg-red-50 hover:text-red-500 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                        Hapus dari Library
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: Book Details -->
            <div class="md:col-span-8 pt-1">

                <!-- Category badge -->
                @if ($book->category)
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-primary bg-primary/10 px-3 py-1 rounded-full mb-4">
                        {{ $book->category->name }}
                    </span>
                @endif

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold font-heading text-text leading-tight mb-2">
                    {{ $book->judul }}
                </h1>

                <!-- Author -->
                <p class="text-base text-text/50 mb-7">oleh <span class="text-text/70 font-semibold">{{ $book->penulis }}</span></p>

                <!-- Quick Stats Row -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5">
                        <svg class="w-4 h-4 text-text/30 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                        </svg>
                        <div>
                            <p class="text-[10px] text-text/35 uppercase tracking-wider leading-none mb-0.5">Penerbit</p>
                            <p class="text-sm font-semibold text-text leading-none">{{ $book->penerbit }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5">
                        <svg class="w-4 h-4 text-text/30 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        <div>
                            <p class="text-[10px] text-text/35 uppercase tracking-wider leading-none mb-0.5">Tahun</p>
                            <p class="text-sm font-semibold text-text leading-none">{{ $book->tahun_terbit }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5">
                        <svg class="w-4 h-4 text-text/30 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                        </svg>
                        <div>
                            <p class="text-[10px] text-text/35 uppercase tracking-wider leading-none mb-0.5">Dipinjam</p>
                            <p class="text-sm font-semibold text-text leading-none">{{ $book->transactions_count ?? $book->transactions()->count() }}×</p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="h-px bg-gray-200 mb-7"></div>

                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-sm font-bold text-text/40 uppercase tracking-widest mb-3">Deskripsi</h2>
                    <div class="text-text/65 leading-relaxed text-[0.95rem]">
                        <p>{{ Str::limit($book->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.', 400) }}</p>

                        @if ($book->deskripsi && strlen($book->deskripsi) > 400)
                            <button onclick="toggleModal('descriptionModal')"
                                class="mt-3 text-sm font-semibold text-primary hover:underline focus:outline-none inline-flex items-center gap-1">
                                Selengkapnya
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Detail Buku -->
                <div class="rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3.5 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-text/40 uppercase tracking-widest">Detail Buku</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Penulis</span>
                            <span class="text-sm text-text font-medium">{{ $book->penulis }}</span>
                        </div>
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Penerbit</span>
                            <span class="text-sm text-text font-medium">{{ $book->penerbit }}</span>
                        </div>
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Tahun Terbit</span>
                            <span class="text-sm text-text font-medium">{{ $book->tahun_terbit }}</span>
                        </div>
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Kategori</span>
                            <span class="text-sm text-text font-medium">{{ $book->category->name ?? '—' }}</span>
                        </div>
                        @if($book->jumlah_halaman)
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Jumlah Halaman</span>
                            <span class="text-sm text-text font-medium">{{ number_format($book->jumlah_halaman) }} halaman</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Stok</span>
                            <span class="text-sm font-semibold {{ $book->stok > 0 ? 'text-accent' : 'text-red-500' }}">
                                {{ $book->stok }} tersedia
                            </span>
                        </div>
                        <div class="flex justify-between items-center px-5 py-3">
                            <span class="text-sm text-text/45">Total Dipinjam</span>
                            <span class="text-sm text-text font-medium">{{ $book->transactions_count ?? $book->transactions()->count() }} kali</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Description Modal -->
    <div id="descriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleModal('descriptionModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-text">Deskripsi Lengkap</h3>
                        <p class="text-sm text-text/40 mt-0.5">{{ $book->judul }}</p>
                    </div>
                    <button onclick="toggleModal('descriptionModal')" class="text-text/30 hover:text-text/60 transition-colors p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-6 max-h-[60vh] overflow-y-auto">
                    <p class="text-text/70 leading-relaxed">{{ $book->deskripsi }}</p>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-right">
                    <button onclick="toggleModal('descriptionModal')"
                        class="bg-primary hover:bg-secondary text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ── Book Display ── */
        .show-book-area {
            min-height: 450px;
            position: relative;
            overflow: hidden;
        }

        /* Scene with perspective */
        .show-book-scene {
            perspective: 1000px;
        }

        /* Book wrapper – flat by default, tilts on hover */
        .show-book-wrap {
            width: 270px;
            height: 385px;
            position: relative;
            transform-style: preserve-3d;
            transform: rotateY(0deg) rotateX(0deg);
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1), filter 0.5s ease;
        }
        .show-book-wrap:hover {
            transform: rotateY(-18deg) rotateX(3deg) scale(1.03) translateY(-4px);
            filter: drop-shadow(0 16px 20px rgba(0,0,0,0.15));
        }

        /* ── Front Cover ── */
        .show-front-cover {
            position: absolute;
            inset: 0;
            border-radius: 2px 8px 8px 2px;
            overflow: hidden;
            background: #c8c8c8;
            box-shadow: 6px 10px 28px rgba(0,0,0,0.15), 2px 2px 6px rgba(0,0,0,0.1);
            z-index: 10;
        }

        /* ── Pages ── */
        .show-pages {
            position: absolute;
            inset: 4px 2px 4px 0;
            border-radius: 2px 8px 8px 2px;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            transform: translateZ(-5px) translateX(2px);
            z-index: 5;
            overflow: hidden;
            box-shadow: inset 4px 0 10px rgba(0,0,0,0.05);
            transition: transform 0.55s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        /* Individual page lines */
        .show-pages::before {
            content: '';
            position: absolute;
            top: 0; right: 2px; bottom: 0; left: 0;
            background: repeating-linear-gradient(to right, transparent, transparent 1px, rgba(0,0,0,0.04) 2px, transparent 3px);
        }

        /* ── Back Cover ── */
        .show-back-cover {
            position: absolute;
            inset: 0;
            border-radius: 2px 10px 10px 2px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            transform: translateZ(-8px) translateX(4px);
            z-index: 1;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.55s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.55s;
        }

        .show-book-wrap:hover .show-pages {
            transform: translateZ(-5px) translateX(5px);
        }
        .show-book-wrap:hover .show-back-cover {
            transform: translateZ(-8px) translateX(9px);
            box-shadow: 4px 4px 10px rgba(0,0,0,0.1);
        }
    </style>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    </script>
@endsection
