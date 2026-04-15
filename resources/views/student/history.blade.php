@extends('layouts.app')

@section('title', 'Riwayat Pinjam')

@section('content')
    <div class="space-y-5">

        <div>
            <h1 class="text-xl sm:text-2xl font-bold font-heading text-text">Riwayat Pinjam</h1>
            <p class="text-sm text-text/50 mt-1">Peminjaman dan riwayat bacaanmu.</p>
        </div>

        @if (session('success'))
            <div class="bg-accent/10 border border-accent/20 text-accent px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-primary/10 border border-primary/20 text-secondary px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex gap-1 bg-text/5 p-1 rounded-xl w-fit">
            <a href="{{ request()->fullUrlWithQuery(['tab' => 'aktif']) }}"
                class="px-4 py-1.5 text-sm font-semibold rounded-lg transition-all {{ $tab === 'aktif' ? 'bg-background text-text shadow-sm' : 'text-text/50 hover:text-text/70' }}">
                Aktif ({{ $transactions->whereIn('status', ['menunggu_pengambilan', 'dipinjam', 'mengembalikan'])->count() }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['tab' => 'selesai']) }}"
                class="px-4 py-1.5 text-sm font-semibold rounded-lg transition-all {{ $tab === 'selesai' ? 'bg-background text-text shadow-sm' : 'text-text/50 hover:text-text/70' }}">
                Selesai ({{ $transactions->whereIn('status', ['kembali', 'dibatalkan'])->count() }})
            </a>
        </div>

        <div class="space-y-2.5">
            @forelse ($filtered as $trx)
                <div class="bg-background rounded-xl border border-text/8 overflow-hidden">
                    <div class="flex min-h-[88px]">

                        <div class="w-1 shrink-0 {{ $trx->accent_color }}"></div>

                        <a href="{{ route('book.show', $trx->book->slug) }}"
                           class="shrink-0 flex items-center justify-center bg-text/2 px-4 py-4 group w-[76px] sm:w-[88px]">
                            <div class="[perspective:700px]">
                                <div class="relative w-[60px] h-[84px] sm:w-[68px] sm:h-[96px] [transform-style:preserve-3d] [-webkit-transform:rotateY(-16deg)_rotateX(2deg)] transition-transform duration-400 [transition-timing-function:cubic-bezier(0.2,0.8,0.2,1)] group-hover:[-webkit-transform:rotateY(-22deg)_rotateX(3deg)_scale(1.05)]">
                                    <div class="absolute inset-0 bg-white rounded-l-[1px] rounded-r-[6px] [transform:translateZ(-8px)_translateX(8px)] shadow-[3px_5px_12px_rgba(0,0,0,0.18)] z-1"></div>
                                    <div class="absolute top-[3px] right-0 bottom-[3px] left-[1px] bg-[#f5f5f0] border border-text/10 rounded-l-[1px] rounded-r-[5px] [transform:translateZ(-4px)_translateX(5px)] z-5
                                        before:content-[''] before:absolute before:inset-0 before:bg-[repeating-linear-gradient(to_right,transparent,transparent_1px,rgba(0,0,0,0.03)_1.5px,transparent_2.5px)]"></div>
                                    <div class="absolute inset-0 rounded-l-[1px] rounded-r-[6px] overflow-hidden bg-background shadow-[0_4px_12px_rgba(0,0,0,0.15)] z-10">
                                        @if ($trx->book->cover_url)
                                            <img src="{{ $trx->book->cover_url }}" alt="{{ $trx->book->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center p-1.5 bg-gradient-to-br from-gray-600 to-gray-800">
                                                <p class="text-white/90 text-center font-bold text-[8px] leading-tight">{{ $trx->book->judul }}</p>
                                            </div>
                                        @endif
                                        <div class="absolute inset-y-0 left-0 w-2 bg-gradient-to-r from-black/30 to-transparent pointer-events-none"></div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="flex-1 min-w-0 py-3.5 px-3 sm:px-4 flex flex-col justify-between gap-2">
                            <div>
                                <div class="flex items-start gap-2 flex-wrap">
                                    <a href="{{ route('book.show', $trx->book->slug) }}"
                                       class="font-bold text-text text-sm leading-snug hover:text-primary transition-colors line-clamp-1">
                                        {{ $trx->book->judul }}
                                    </a>
                                    @if ($trx->status === 'menunggu_pengambilan')
                                        <span class="shrink-0 text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">Menunggu Diambil</span>
                                    @elseif ($trx->status === 'mengembalikan')
                                        <span class="shrink-0 text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Proses Kembali</span>
                                    @elseif ($trx->status === 'dipinjam')
                                        @if ($trx->is_terlambat)
                                            <span class="shrink-0 text-[10px] font-bold text-secondary bg-secondary/8 border border-secondary/20 px-2 py-0.5 rounded-full">Terlambat {{ $trx->hari_telat }} hari</span>
                                        @else
                                            <span class="shrink-0 text-[10px] font-bold text-primary bg-primary/8 border border-primary/15 px-2 py-0.5 rounded-full">Dipinjam</span>
                                        @endif
                                    @elseif ($trx->status === 'kembali')
                                        <span class="shrink-0 text-[10px] font-bold text-accent bg-accent/8 border border-accent/15 px-2 py-0.5 rounded-full">Selesai</span>
                                    @else
                                        <span class="shrink-0 text-[10px] font-bold text-text/40 bg-text/5 border border-text/10 px-2 py-0.5 rounded-full">Dibatalkan</span>
                                    @endif
                                </div>
                                <p class="text-xs text-text/40 mt-0.5 truncate">{{ $trx->book->penulis }}</p>
                            </div>

                            <div class="flex flex-wrap gap-x-3 gap-y-0.5">
                                <span class="text-[11px] text-text/35">
                                    Pinjam: {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->translatedFormat('d M Y') }}
                                </span>
                                @if ($trx->due_date && $trx->status === 'dipinjam')
                                    <span class="text-[11px] {{ $trx->is_terlambat ? 'text-secondary font-semibold' : 'text-text/35' }}">
                                        Tempo: {{ \Carbon\Carbon::parse($trx->due_date)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                                @if ($trx->tanggal_kembali)
                                    <span class="text-[11px] text-accent">
                                        Kembali: {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="shrink-0 flex flex-col items-center justify-center gap-1.5 py-3.5 pr-4 pl-3 border-l border-text/5 w-[130px] sm:w-[150px]">

                            @if ($trx->status === 'menunggu_pengambilan')
                                <p class="text-[9px] font-semibold text-blue-500 uppercase tracking-wider">Kode Ambil</p>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg px-2 py-1.5 w-full text-center">
                                    <span class="font-black text-sm text-blue-700 tracking-widest font-mono">{{ $trx->pickup_code }}</span>
                                </div>
                                <form action="{{ route('buku.batalkan', $trx->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin mau batalkan peminjaman buku ini?');" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-[10px] font-semibold text-text/35 hover:text-primary transition-colors py-0.5">
                                        Batalkan
                                    </button>
                                </form>

                            @elseif ($trx->status === 'mengembalikan')
                                <p class="text-[9px] font-semibold text-amber-500 uppercase tracking-wider">Kode Kembali</p>
                                <div class="bg-amber-50 border border-amber-200 rounded-lg px-2 py-1.5 w-full text-center">
                                    <span class="font-black text-sm text-amber-700 tracking-widest font-mono">{{ $trx->return_code }}</span>
                                </div>

                            @elseif ($trx->status === 'dipinjam')
                                @php
                                    $confirmMsg = $trx->is_terlambat
                                        ? 'Kamu terlambat ' . $trx->hari_telat . ' hari. Estimasi denda: Rp' . number_format($trx->denda_berjalan, 0, ',', '.') . '.\\nYakin mau dikembalikan?'
                                        : 'Sudah selesai baca? Yakin mau kembalikan buku ini?';
                                @endphp
                                <form action="{{ route('buku.kembalikan', $trx->id) }}" method="POST"
                                      onsubmit="return confirm('{{ $confirmMsg }}');" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full {{ $trx->is_terlambat ? 'bg-secondary hover:bg-secondary/90' : 'bg-primary hover:bg-primary/90' }} text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-colors">
                                        Kembalikan
                                    </button>
                                </form>

                            @elseif ($trx->status === 'kembali')
                                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-[10px] font-semibold text-accent">Selesai</p>

                            @else
                                <svg class="w-6 h-6 text-text/20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-[10px] font-semibold text-text/30">Dibatalkan</p>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-background rounded-xl border border-dashed border-text/10">
                    <svg class="w-12 h-12 text-text/10 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <p class="text-base font-bold text-text/40">Tidak ada peminjaman</p>
                    <a href="{{ route('student.katalog') }}"
                        class="mt-4 inline-flex items-center gap-2 bg-primary text-white font-semibold text-sm px-5 py-2.5 rounded-xl">
                        Cari Buku
                    </a>
                </div>
            @endforelse
        </div>

    </div>

@endsection
