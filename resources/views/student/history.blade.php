@extends('layouts.app')

@section('title', 'Buku Saya')

@section('content')
    @php
        $dipinjam        = $transactions->where('status', 'dipinjam');
        $menunggu        = $transactions->where('status', 'menunggu_pengambilan');
        $mengembalikan   = $transactions->where('status', 'mengembalikan');
        $dikembalikan    = $transactions->where('status', 'kembali');
        $terlambatCount  = $dipinjam->filter(fn($t) =>
            $t->due_date && \Carbon\Carbon::now()->gt($t->due_date)
        )->count();
    @endphp

    <div class="space-y-5 sm:space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold font-heading text-text">Buku Saya</h1>
                <p class="text-sm text-text/50 mt-1">Kelola peminjaman dan riwayat bacaanmu.</p>
            </div>

            {{-- Stats --}}
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <div class="bg-background border border-text/10 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 text-center min-w-16">
                    <p class="text-lg sm:text-xl font-black text-text">{{ $dipinjam->count() }}</p>
                    <p class="text-[10px] sm:text-[11px] font-medium text-text/40 mt-0.5">Dipinjam</p>
                </div>
                @if ($menunggu->count() > 0)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 text-center min-w-16">
                        <p class="text-lg sm:text-xl font-black text-blue-600">{{ $menunggu->count() }}</p>
                        <p class="text-[10px] sm:text-[11px] font-medium text-blue-500 mt-0.5">Dipesan</p>
                    </div>
                @endif
                @if ($mengembalikan->count() > 0)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 text-center min-w-16">
                        <p class="text-lg sm:text-xl font-black text-amber-600">{{ $mengembalikan->count() }}</p>
                        <p class="text-[10px] sm:text-[11px] font-medium text-amber-500 mt-0.5">Proses Kembali</p>
                    </div>
                @endif
                <div class="bg-background border border-text/10 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 text-center min-w-16">
                    <p class="text-lg sm:text-xl font-black text-text">{{ $dikembalikan->count() }}</p>
                    <p class="text-[10px] sm:text-[11px] font-medium text-text/40 mt-0.5">Selesai</p>
                </div>
                @if ($terlambatCount > 0)
                    <div class="bg-primary/10 border border-primary/20 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 text-center min-w-16">
                        <p class="text-lg sm:text-xl font-black text-primary">{{ $terlambatCount }}</p>
                        <p class="text-[10px] sm:text-[11px] font-medium text-primary/60 mt-0.5">Terlambat</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Notifikasi pengambilan aktif --}}
        @if ($menunggu->count() > 0)
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 sm:p-5">
                <div class="flex items-start gap-3 sm:gap-4">
                    <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-blue-800 text-sm">
                            {{ $menunggu->count() > 1 ? $menunggu->count() . ' buku menunggu pengambilan' : 'Buku siap diambil!' }}
                        </p>
                        <p class="text-blue-700 text-xs sm:text-sm mt-1">Tunjukkan kode berikut ke petugas perpustakaan saat mengambil buku:</p>
                        <div class="mt-3 flex flex-wrap gap-2 sm:gap-3">
                            @foreach ($menunggu as $trxAmbil)
                                <div class="bg-white border-2 border-blue-300 rounded-xl px-3 sm:px-4 py-2 sm:py-3 flex flex-col gap-1 min-w-40 sm:min-w-48">
                                    <p class="text-[10px] font-semibold text-blue-500 uppercase tracking-wide truncate">{{ $trxAmbil->book->judul }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-lg sm:text-xl text-blue-700 tracking-widest" style="font-family: monospace; letter-spacing: 0.15em;">{{ $trxAmbil->pickup_code }}</span>
                                        <button onclick="navigator.clipboard.writeText('{{ $trxAmbil->pickup_code }}').then(() => { this.textContent='Disalin!'; setTimeout(()=>this.textContent='Salin',1500) })"
                                            class="text-[10px] font-semibold bg-blue-100 hover:bg-blue-200 text-blue-700 px-2 py-0.5 rounded-lg transition-colors shrink-0">
                                            Salin
                                        </button>
                                    </div>
                                    <p class="text-[10px] text-blue-500">Ambil: {{ \Carbon\Carbon::parse($trxAmbil->tanggal_ambil)->translatedFormat('d M Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-blue-600 text-xs mt-3">Kode hanya berlaku untuk pengambilan buku ini. Jaga kerahasiaannya.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Notifikasi pengembalian aktif --}}
        @if ($mengembalikan->count() > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 sm:p-5">
                <div class="flex items-start gap-3 sm:gap-4">
                    <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-amber-800 text-sm">
                            {{ $mengembalikan->count() > 1 ? $mengembalikan->count() . ' buku menunggu konfirmasi pengembalian' : 'Permintaan pengembalian dikirim!' }}
                        </p>
                        <p class="text-amber-700 text-xs sm:text-sm mt-1">Tunjukkan kode berikut ke petugas perpustakaan:</p>
                        <div class="mt-3 flex flex-wrap gap-2 sm:gap-3">
                            @foreach ($mengembalikan as $trxKembali)
                                <div class="bg-white border-2 border-amber-300 rounded-xl px-3 sm:px-4 py-2 sm:py-3 flex flex-col gap-1 min-w-40 sm:min-w-48">
                                    <p class="text-[10px] font-semibold text-amber-500 uppercase tracking-wide truncate">{{ $trxKembali->book->judul }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-lg sm:text-xl text-amber-700 tracking-widest" style="font-family: monospace; letter-spacing: 0.15em;">{{ $trxKembali->return_code }}</span>
                                        <button onclick="navigator.clipboard.writeText('{{ $trxKembali->return_code }}').then(() => { this.textContent='Disalin!'; setTimeout(()=>this.textContent='Salin',1500) })"
                                            class="text-[10px] font-semibold bg-amber-100 hover:bg-amber-200 text-amber-700 px-2 py-0.5 rounded-lg transition-colors shrink-0">
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-amber-600 text-xs mt-3">Setiap kode hanya berlaku sekali dan akan hilang setelah dikonfirmasi petugas.</p>
                    </div>
                </div>
            </div>
        @endif

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

        {{-- Tab Filter --}}
        <div class="overflow-x-auto scrollbar-hide -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            <div class="flex gap-1 bg-text/5 p-1 rounded-xl w-max min-w-full sm:w-fit">
                <button onclick="switchTab('semua')"
                    class="tab-btn whitespace-nowrap px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all text-text/50"
                    data-tab="semua">
                    Semua ({{ $transactions->count() }})
                </button>
                <button onclick="switchTab('dipinjam')"
                    class="tab-btn whitespace-nowrap px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all bg-background text-text shadow-sm"
                    data-tab="dipinjam">
                    Dipinjam ({{ $dipinjam->count() }})
                </button>
                @if ($menunggu->count() > 0)
                    <button onclick="switchTab('menunggu_pengambilan')"
                        class="tab-btn whitespace-nowrap px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all text-text/50"
                        data-tab="menunggu_pengambilan">
                        Menunggu Diambil ({{ $menunggu->count() }})
                    </button>
                @endif
                @if ($mengembalikan->count() > 0)
                    <button onclick="switchTab('mengembalikan')"
                        class="tab-btn whitespace-nowrap px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all text-text/50"
                        data-tab="mengembalikan">
                        Proses Kembali ({{ $mengembalikan->count() }})
                    </button>
                @endif
                <button onclick="switchTab('kembali')"
                    class="tab-btn whitespace-nowrap px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all text-text/50"
                    data-tab="kembali">
                    Selesai ({{ $dikembalikan->count() }})
                </button>
            </div>
        </div>

        {{-- Book Cards --}}
        <div class="space-y-2.5" id="bookList">
            @forelse ($transactions as $trx)
                @php
                    $terlambat     = $trx->status === 'dipinjam' && $trx->due_date && \Carbon\Carbon::now()->gt($trx->due_date);
                    $hariTelat     = $trx->hari_telat;
                    $estimasiDenda = $trx->denda_berjalan;
                    $sisaHari      = $trx->status === 'dipinjam' && !$terlambat && $trx->due_date
                                       ? (int) \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($trx->due_date)->startOfDay(), false)
                                       : null;
                    $hariMenunggu  = $trx->status === 'menunggu_pengambilan' && $trx->tanggal_ambil
                                       ? (int) \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($trx->tanggal_ambil), false)
                                       : 0;

                    // Warna aksen per status
                    $accentColor = match($trx->status) {
                        'menunggu_pengambilan' => 'bg-blue-500',
                        'mengembalikan'        => 'bg-amber-400',
                        'dipinjam'             => $terlambat ? 'bg-secondary' : 'bg-primary',
                        'kembali'              => 'bg-accent',
                        default                => 'bg-text/20',
                    };
                @endphp

                <div class="book-item bg-background rounded-xl border border-text/8 overflow-hidden transition-shadow duration-200 hover:shadow-md"
                     data-status="{{ $trx->status }}">
                    <div class="flex min-h-[88px]">

                        {{-- Accent stripe --}}
                        <div class="w-1 shrink-0 {{ $accentColor }}"></div>

                        {{-- 3D Cover --}}
                        <a href="{{ route('book.show', $trx->book->slug) }}"
                           class="shrink-0 flex items-center justify-center bg-text/2 px-4 py-4 group w-[76px] sm:w-[88px]">
                            <div class="hist-book-perspective">
                                <div class="hist-book-3d">
                                    <div class="hist-book-back"></div>
                                    <div class="hist-book-pages"></div>
                                    <div class="hist-book-front">
                                        @if ($trx->book->cover_url)
                                            <img src="{{ $trx->book->cover_url }}" alt="{{ $trx->book->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center p-1.5 bg-linear-to-br from-text/40 to-text/60">
                                                <p class="text-white/90 text-center font-bold text-[8px] leading-tight">{{ $trx->book->judul }}</p>
                                            </div>
                                        @endif
                                        <div class="absolute inset-y-0 left-0 w-2 bg-linear-to-r from-black/30 to-transparent pointer-events-none"></div>
                                        <div class="absolute inset-0 bg-linear-to-tr from-transparent via-white/5 to-white/10 pointer-events-none"></div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Info tengah --}}
                        <div class="flex-1 min-w-0 py-3.5 px-3 sm:px-4 flex flex-col justify-between gap-2">

                            {{-- Judul + badge --}}
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
                                        @if ($terlambat)
                                            <span class="shrink-0 text-[10px] font-bold text-secondary bg-secondary/8 border border-secondary/20 px-2 py-0.5 rounded-full">Terlambat {{ $hariTelat }} hari</span>
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

                            {{-- Timeline --}}
                            <div class="flex flex-wrap gap-x-3 gap-y-0.5">
                                <span class="text-[11px] text-text/35 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->translatedFormat('d M Y') }}
                                </span>
                                @if ($trx->tanggal_ambil && $trx->status === 'menunggu_pengambilan')
                                    <span class="text-[11px] text-blue-500 font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                        Ambil {{ \Carbon\Carbon::parse($trx->tanggal_ambil)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                                @if ($trx->due_date && $trx->status === 'dipinjam')
                                    <span class="text-[11px] {{ $terlambat ? 'text-secondary font-semibold' : 'text-text/35' }} flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Tempo {{ \Carbon\Carbon::parse($trx->due_date)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                                @if ($trx->tanggal_kembali)
                                    <span class="text-[11px] text-accent flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Kembali {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                                @if ($trx->denda_berjalan > 0)
                                    <span class="text-[11px] text-secondary font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                                        Denda Rp{{ number_format($trx->denda_berjalan, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Panel aksi kanan --}}
                        <div class="shrink-0 flex flex-col items-end justify-center gap-2 py-3.5 pr-4 pl-3 border-l border-text/5 w-[140px] sm:w-[168px]">

                            @if ($trx->status === 'menunggu_pengambilan')
                                {{-- Kode pengambilan --}}
                                <div class="w-full text-center">
                                    <p class="text-[9px] font-semibold text-blue-500 uppercase tracking-wider mb-1">Kode Ambil</p>
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-2 py-1.5 mb-2">
                                        <span class="font-black text-sm text-blue-700 tracking-widest block" style="font-family: monospace;">{{ $trx->pickup_code }}</span>
                                    </div>
                                    <button onclick="navigator.clipboard.writeText('{{ $trx->pickup_code }}').then(() => { this.textContent='Disalin!'; setTimeout(()=>{ this.textContent='Salin Kode' },1500) })"
                                        class="w-full text-[10px] font-bold bg-blue-100 hover:bg-blue-200 text-blue-700 px-2 py-1 rounded-md transition-colors mb-1.5">
                                        Salin Kode
                                    </button>
                                    <form action="{{ route('buku.batalkan', $trx->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin mau batalkan peminjaman buku ini?');">
                                        @csrf
                                        <button type="submit" class="w-full text-[10px] font-semibold text-text/35 hover:text-primary transition-colors py-0.5">
                                            Batalkan
                                        </button>
                                    </form>
                                </div>

                            @elseif ($trx->status === 'mengembalikan')
                                {{-- Kode pengembalian --}}
                                <div class="w-full text-center">
                                    <p class="text-[9px] font-semibold text-amber-500 uppercase tracking-wider mb-1">Kode Kembali</p>
                                    <div class="bg-amber-50 border border-amber-200 rounded-lg px-2 py-1.5 mb-2">
                                        <span class="font-black text-sm text-amber-700 tracking-widest block" style="font-family: monospace;">{{ $trx->return_code }}</span>
                                    </div>
                                    <button onclick="navigator.clipboard.writeText('{{ $trx->return_code }}').then(() => { this.textContent='Disalin!'; setTimeout(()=>{ this.textContent='Salin Kode' },1500) })"
                                        class="w-full text-[10px] font-bold bg-amber-100 hover:bg-amber-200 text-amber-700 px-2 py-1 rounded-md transition-colors">
                                        Salin Kode
                                    </button>
                                </div>

                            @elseif ($trx->status === 'dipinjam')
                                {{-- Counter + tombol kembalikan --}}
                                <div class="w-full text-center">
                                    @if ($terlambat)
                                        <p class="text-[9px] font-semibold text-secondary/60 uppercase tracking-wider mb-0.5">Terlambat</p>
                                        <p class="text-2xl font-black text-secondary leading-none">{{ $hariTelat }}</p>
                                        <p class="text-[10px] text-secondary/50 font-medium mb-2">hari</p>
                                    @elseif ($sisaHari !== null)
                                        <p class="text-[9px] font-semibold text-text/30 uppercase tracking-wider mb-0.5">Sisa</p>
                                        <p class="text-2xl font-black leading-none {{ $sisaHari <= 3 ? 'text-orange-500' : 'text-text/50' }}">{{ $sisaHari }}</p>
                                        <p class="text-[10px] {{ $sisaHari <= 3 ? 'text-orange-400' : 'text-text/30' }} font-medium mb-2">hari</p>
                                    @else
                                        <div class="mb-2"></div>
                                    @endif
                                    @php
                                        $confirmMsg = $terlambat
                                            ? 'Kamu terlambat ' . $hariTelat . ' hari. Estimasi denda: Rp' . number_format($estimasiDenda, 0, ',', '.') . '.\\nYakin mau dikembalikan?'
                                            : 'Sudah selesai baca? Yakin mau kembalikan buku ini?';
                                    @endphp
                                    <form action="{{ route('buku.kembalikan', $trx->id) }}" method="POST"
                                          onsubmit="return confirm('{{ $confirmMsg }}');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full {{ $terlambat ? 'bg-secondary hover:bg-secondary/90' : 'bg-primary hover:bg-primary/90' }} text-white text-[11px] font-bold px-3 py-2 rounded-lg transition-colors flex items-center justify-center gap-1.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                                            </svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                </div>

                            @elseif ($trx->status === 'kembali')
                                {{-- Selesai --}}
                                <div class="text-center">
                                    <div class="w-8 h-8 rounded-full bg-accent/10 flex items-center justify-center mx-auto mb-1">
                                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-semibold text-accent">Selesai</p>
                                </div>

                            @else
                                {{-- Dibatalkan --}}
                                <div class="text-center">
                                    <div class="w-8 h-8 rounded-full bg-text/5 flex items-center justify-center mx-auto mb-1">
                                        <svg class="w-4 h-4 text-text/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-semibold text-text/30">Dibatalkan</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 sm:py-20 bg-background rounded-xl border border-dashed border-text/10">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 sm:w-14 h-12 sm:h-14 text-text/10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-text/50">Belum ada riwayat peminjaman</h3>
                    <p class="text-sm text-text/40 mt-1">Kamu belum meminjam buku apapun.</p>
                    <a href="{{ route('student.home') }}"
                        class="mt-5 inline-flex items-center gap-2 bg-primary text-background font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-secondary transition shadow-sm">
                        Jelajah Buku
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Empty state per tab --}}
        <div id="emptyTab" class="hidden text-center py-12">
            <p class="text-sm text-text/40 font-medium">Tidak ada buku di kategori ini.</p>
        </div>

    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Mini 3D Book for History ── */
        .hist-book-perspective { perspective: 700px; }
        .hist-book-3d {
            width: 60px; height: 84px;
            position: relative;
            transform-style: preserve-3d;
            transform: rotateY(-16deg) rotateX(2deg);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        @media (min-width: 640px) {
            .hist-book-3d { width: 68px; height: 96px; }
        }
        .group:hover .hist-book-3d {
            transform: rotateY(-22deg) rotateX(3deg) scale(1.05);
        }
        .hist-book-front {
            position: absolute; inset: 0;
            border-radius: 1px 6px 6px 1px;
            overflow: hidden; z-index: 10;
            background: var(--color-background);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .hist-book-pages {
            position: absolute; top: 3px; right: 0; bottom: 3px; left: 1px;
            background: #f5f5f0;
            border: 1px solid var(--color-text);
            border-color: color-mix(in srgb, var(--color-text) 10%, transparent);
            border-radius: 1px 5px 5px 1px;
            transform: translateZ(-4px) translateX(5px); z-index: 5;
        }
        .hist-book-pages::before {
            content: ''; position: absolute; inset: 0;
            background: repeating-linear-gradient(to right, transparent, transparent 1px, rgba(0,0,0,0.03) 1.5px, transparent 2.5px);
        }
        .hist-book-back {
            position: absolute; inset: 0;
            background: #ffffff;
            border-radius: 1px 6px 6px 1px;
            transform: translateZ(-8px) translateX(8px);
            box-shadow: 3px 5px 12px rgba(0,0,0,0.18); z-index: 1;
        }
    </style>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-background', 'text-text', 'shadow-sm');
                btn.classList.add('text-text/50');
                if (btn.dataset.tab === tab) {
                    btn.classList.add('bg-background', 'text-text', 'shadow-sm');
                    btn.classList.remove('text-text/50');
                }
            });

            const items = document.querySelectorAll('.book-item');
            let visibleCount = 0;
            items.forEach(item => {
                const show = tab === 'semua' || item.dataset.status === tab;
                item.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            document.getElementById('emptyTab').classList.toggle('hidden', visibleCount > 0 || items.length === 0);
        }

        switchTab('dipinjam');
    </script>
@endsection
