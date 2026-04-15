@extends('layouts.app')

@section('title', $book->judul)

@section('content')
    <div class="max-w-5xl mx-auto">

        
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 mb-8 text-sm font-medium text-text/50 hover:text-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali
        </a>

        
        <div class="grid md:grid-cols-12 gap-10">

            
            <div class="md:col-span-4">
                <div class="sticky top-8">

                    
                    <div class="rounded-2xl flex flex-col justify-center items-center py-6 px-2 bg-gray-100">
                        <div class="[perspective:1000px]">
                            <div class="group relative w-[270px] h-[385px] [transform-style:preserve-3d] transition-transform duration-500 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] hover:[-webkit-transform:rotateY(-18deg)_rotateX(3deg)_scale(1.03)_translateY(-4px)]">
                                <div class="absolute inset-0 bg-white border border-gray-200 rounded-l-[2px] rounded-r-[10px] [transform:translateZ(-8px)_translateX(4px)] z-1 transition-transform duration-550 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] group-hover:[transform:translateZ(-8px)_translateX(9px)]"></div>
                                <div class="absolute inset-[4px_2px_4px_0] bg-gray-100 border border-gray-200 rounded-l-[2px] rounded-r-[8px] [transform:translateZ(-5px)_translateX(2px)] z-5 transition-transform duration-550 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] group-hover:[transform:translateZ(-5px)_translateX(5px)]
                                    before:content-[''] before:absolute before:inset-[0_2px_0_0] before:bg-[repeating-linear-gradient(to_right,transparent,transparent_1px,rgba(0,0,0,0.04)_2px,transparent_3px)]"></div>
                                <div class="absolute inset-0 rounded-l-[2px] rounded-r-[8px] overflow-hidden bg-[#c8c8c8] shadow-[6px_10px_28px_rgba(0,0,0,0.15)] z-10">
                                    @if ($book->gambar)
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-700 to-gray-900 gap-3">
                                            <svg class="w-8 h-8 text-white/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                                            </svg>
                                            <p class="text-white text-center font-bold text-sm leading-snug">{{ $book->judul }}</p>
                                        </div>
                                    @endif
                                    <div class="absolute inset-y-0 left-0 w-5 bg-gradient-to-r from-black/30 to-transparent pointer-events-none rounded-l-sm"></div>
                                    <div class="absolute inset-y-0 left-0 w-[2px] bg-white/15 pointer-events-none"></div>
                                    <div class="absolute inset-y-0 left-[5px] w-[1px] bg-black/10 pointer-events-none"></div>
                                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-transparent pointer-events-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    @if (session('error'))
                        <div class="mt-4 bg-primary/10 border border-primary/20 text-secondary text-sm font-medium px-4 py-3 rounded-xl text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    
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

                    
                    <div class="mt-2.5 text-center">
                        @if($book->stok > 0)
                            <span class="text-xs text-text/40">Stok tersedia: <span class="font-semibold text-accent">{{ $book->stok }}</span> buku</span>
                        @else
                            <span class="text-xs font-semibold text-primary">Stok tidak tersedia saat ini</span>
                        @endif
                    </div>

                    @php
                        $libraryEntry = \App\Models\UserLibrary::where('user_id', auth()->id())
                            ->where('book_id', $book->id)
                            ->first();
                    @endphp
                    <div class="mt-3">
                        @if ($libraryEntry)
                            <form action="{{ route('library.destroy', $book) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl border transition-all text-sm font-semibold bg-accent/10 border-accent/20 text-accent hover:bg-accent/20">
                                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/></svg>
                                    Tersimpan di Library
                                </button>
                            </form>
                        @else
                            <form action="{{ route('library.store', $book) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="saved">
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl border transition-all text-sm font-semibold bg-gray-50 border-gray-200 text-text/60 hover:bg-gray-100 hover:text-text">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/></svg>
                                    Simpan ke Library
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>

            
            <div class="md:col-span-8 pt-1">

                
                @if ($book->category)
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-primary bg-primary/10 px-3 py-1 rounded-full mb-4">
                        {{ $book->category->name }}
                    </span>
                @endif

                
                <h1 class="text-3xl md:text-4xl font-bold font-heading text-text leading-tight mb-2">
                    {{ $book->judul }}
                </h1>

                
                <p class="text-base text-text/50 mb-7">oleh <span class="text-text/70 font-semibold">{{ $book->penulis }}</span></p>

                
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

                
                <div class="h-px bg-gray-200 mb-7"></div>

                
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
