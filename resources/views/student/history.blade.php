@extends('layouts.app')

@section('title', 'Buku Saya')

@section('content')
    @php
        $dipinjam        = $transactions->where('status', 'dipinjam');
        $mengembalikan   = $transactions->where('status', 'mengembalikan');
        $dikembalikan    = $transactions->where('status', 'kembali');
        $terlambatCount  = $dipinjam->filter(fn($t) =>
            $t->due_date && \Carbon\Carbon::now()->gt($t->due_date)
        )->count();
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-text">Buku Saya</h1>
                <p class="text-sm text-text/50 mt-1">Kelola peminjaman dan riwayat bacaanmu.</p>
            </div>

            {{-- Stats --}}
            <div class="flex gap-3">
                <div class="bg-background border border-text/10 rounded-xl px-4 py-2.5 text-center min-w-18">
                    <p class="text-xl font-black text-text">{{ $dipinjam->count() }}</p>
                    <p class="text-[11px] font-medium text-text/40 mt-0.5">Dipinjam</p>
                </div>
                @if ($mengembalikan->count() > 0)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-2.5 text-center min-w-18">
                        <p class="text-xl font-black text-amber-600">{{ $mengembalikan->count() }}</p>
                        <p class="text-[11px] font-medium text-amber-500 mt-0.5">Proses Kembali</p>
                    </div>
                @endif
                <div class="bg-background border border-text/10 rounded-xl px-4 py-2.5 text-center min-w-18">
                    <p class="text-xl font-black text-text">{{ $dikembalikan->count() }}</p>
                    <p class="text-[11px] font-medium text-text/40 mt-0.5">Selesai</p>
                </div>
                @if ($terlambatCount > 0)
                    <div class="bg-primary/10 border border-primary/20 rounded-xl px-4 py-2.5 text-center min-w-18">
                        <p class="text-xl font-black text-primary">{{ $terlambatCount }}</p>
                        <p class="text-[11px] font-medium text-primary/60 mt-0.5">Terlambat</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Notifikasi pengembalian aktif --}}
        @if ($mengembalikan->count() > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-amber-800 text-sm">
                            {{ $mengembalikan->count() > 1 ? $mengembalikan->count() . ' buku menunggu konfirmasi pengembalian' : 'Permintaan pengembalian dikirim!' }}
                        </p>
                        <p class="text-amber-700 text-sm mt-1">Tunjukkan kode berikut ke petugas perpustakaan saat mengembalikan buku:</p>
                        <div class="mt-3 flex flex-wrap gap-3">
                            @foreach ($mengembalikan as $trxKembali)
                                <div class="bg-white border-2 border-amber-300 rounded-xl px-4 py-3 flex flex-col gap-1 min-w-48">
                                    <p class="text-[10px] font-semibold text-amber-500 uppercase tracking-wide truncate">{{ $trxKembali->book->judul }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-xl text-amber-700 tracking-widest" style="font-family: monospace; letter-spacing: 0.15em;">{{ $trxKembali->return_code }}</span>
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
        <div class="flex gap-1 bg-text/5 p-1 rounded-xl w-fit flex-wrap">
            <button onclick="switchTab('semua')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all bg-background text-text shadow-sm"
                data-tab="semua">
                Semua ({{ $transactions->count() }})
            </button>
            <button onclick="switchTab('dipinjam')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all text-text/50"
                data-tab="dipinjam">
                Dipinjam ({{ $dipinjam->count() }})
            </button>
            @if ($mengembalikan->count() > 0)
                <button onclick="switchTab('mengembalikan')"
                    class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all text-text/50"
                    data-tab="mengembalikan">
                    Proses Kembali ({{ $mengembalikan->count() }})
                </button>
            @endif
            <button onclick="switchTab('kembali')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg transition-all text-text/50"
                data-tab="kembali">
                Selesai ({{ $dikembalikan->count() }})
            </button>
        </div>

        {{-- Book Cards --}}
        <div class="space-y-3" id="bookList">
            @forelse ($transactions as $trx)
                @php
                    $terlambat       = $trx->status === 'dipinjam' && $trx->due_date && \Carbon\Carbon::now()->gt($trx->due_date);
                    $hariTelat       = $terlambat ? (int) \Carbon\Carbon::now()->diffInDays($trx->due_date) : 0;
                    $estimasiDenda   = $hariTelat * 1000;
                    $belumDiambil    = $trx->status === 'dipinjam' && $trx->tanggal_ambil && \Carbon\Carbon::today()->lt(\Carbon\Carbon::parse($trx->tanggal_ambil));
                    $hariMenunggu    = $belumDiambil ? (int) \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($trx->tanggal_ambil)) : 0;
                    $sisaHari        = !$terlambat && !$belumDiambil && $trx->status === 'dipinjam' && $trx->due_date
                                          ? (int) \Carbon\Carbon::now()->diffInDays($trx->due_date, false)
                                          : null;
                    $sedangKembali   = $trx->status === 'mengembalikan';
                @endphp

                <div class="book-item bg-background rounded-xl border transition-all duration-200 overflow-hidden
                     {{ $sedangKembali ? 'border-amber-200 bg-amber-50/30' : 'border-text/5 hover:border-text/10 hover:shadow-sm' }}"
                     data-status="{{ $trx->status }}">
                    <div class="flex">

                        {{-- 3D Book Cover --}}
                        <a href="{{ route('book.show', $trx->book->slug) }}"
                            class="shrink-0 flex items-center justify-center bg-text/2 px-5 py-5 group"
                            style="min-width: 110px;">
                            <div class="hist-book-perspective">
                                <div class="hist-book-3d group-hover:hist-book-hover">
                                    <div class="hist-book-back"></div>
                                    <div class="hist-book-pages"></div>
                                    <div class="hist-book-front">
                                        @if ($trx->book->cover_url)
                                            <img src="{{ $trx->book->cover_url }}" alt="{{ $trx->book->judul }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center p-2 bg-linear-to-br from-text/40 to-text/60">
                                                <p class="text-white/90 text-center font-bold text-[9px] leading-tight">{{ $trx->book->judul }}</p>
                                            </div>
                                        @endif
                                        <div class="absolute inset-y-0 left-0 w-2.5 bg-linear-to-r from-black/30 to-transparent pointer-events-none"></div>
                                        <div class="absolute inset-0 bg-linear-to-tr from-transparent via-white/5 to-white/10 pointer-events-none"></div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="flex-1 px-5 py-4 flex flex-col sm:flex-row sm:items-center gap-4 min-w-0">

                            {{-- Info Buku --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <a href="{{ route('book.show', $trx->book->slug) }}"
                                       class="font-bold text-text text-base leading-tight hover:text-primary transition-colors line-clamp-1">
                                        {{ $trx->book->judul }}
                                    </a>
                                    @if ($sedangKembali)
                                        <span class="shrink-0 text-[10px] font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full border border-amber-200">Menunggu Konfirmasi</span>
                                    @elseif ($trx->status === 'dipinjam')
                                        @if ($terlambat)
                                            <span class="shrink-0 text-[10px] font-bold bg-primary/10 text-primary px-2 py-0.5 rounded-full">Terlambat {{ $hariTelat }}h</span>
                                        @elseif ($belumDiambil)
                                            <span class="shrink-0 text-[10px] font-bold bg-cta text-text/70 px-2 py-0.5 rounded-full">Belum Diambil</span>
                                        @else
                                            <span class="shrink-0 text-[10px] font-bold bg-primary/10 text-primary px-2 py-0.5 rounded-full">Dipinjam</span>
                                        @endif
                                    @else
                                        <span class="shrink-0 text-[10px] font-bold bg-accent/10 text-accent px-2 py-0.5 rounded-full">Selesai</span>
                                    @endif
                                </div>

                                <p class="text-sm text-text/40 mb-3">{{ $trx->book->penulis }}</p>

                                {{-- Timeline --}}
                                <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-text/40">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Dipesan {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->translatedFormat('d M Y') }}</span>
                                    </div>

                                    @if ($trx->tanggal_ambil)
                                        @php $belumDiambil = $trx->status === 'dipinjam' && \Carbon\Carbon::today()->lt(\Carbon\Carbon::parse($trx->tanggal_ambil)); @endphp
                                        <div class="flex items-center gap-1.5 {{ $belumDiambil ? 'text-primary font-semibold' : '' }}">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                            </svg>
                                            <span>Ambil {{ \Carbon\Carbon::parse($trx->tanggal_ambil)->translatedFormat('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if ($trx->due_date)
                                        <div class="flex items-center gap-1.5 {{ $terlambat ? 'text-secondary font-semibold' : '' }}">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Tempo {{ \Carbon\Carbon::parse($trx->due_date)->translatedFormat('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if ($trx->tanggal_kembali)
                                        <div class="flex items-center gap-1.5 text-accent">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Kembali {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->translatedFormat('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if ($trx->fine > 0)
                                        <div class="flex items-center gap-1.5 text-secondary font-semibold">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                                            </svg>
                                            <span>Denda Rp{{ number_format($trx->fine, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Action / Right side --}}
                            <div class="shrink-0 flex flex-col items-end gap-2">
                                @if ($sedangKembali)
                                    <div class="text-right">
                                        <p class="text-[10px] text-amber-600 font-semibold mb-1.5">Kode pengembalianmu:</p>
                                        <div class="inline-flex items-center gap-2 bg-white border-2 border-amber-300 rounded-xl px-3 py-2">
                                            <span class="font-black text-base text-amber-700 tracking-widest" style="font-family: monospace;">{{ $trx->return_code }}</span>
                                            <button onclick="navigator.clipboard.writeText('{{ $trx->return_code }}').then(() => { this.textContent='Disalin!'; setTimeout(()=>this.textContent='Salin',1500) })"
                                                class="text-[10px] font-semibold bg-amber-100 hover:bg-amber-200 text-amber-700 px-2 py-0.5 rounded-lg transition-colors">
                                                Salin
                                            </button>
                                        </div>
                                        <p class="text-[10px] text-amber-500 mt-1.5">Tunjukkan ke petugas perpus</p>
                                    </div>
                                @elseif ($trx->status === 'dipinjam')
                                    @if ($terlambat)
                                        <div class="text-center mb-1">
                                            <span class="text-2xl font-black text-secondary">{{ $hariTelat }}</span>
                                            <p class="text-[10px] text-secondary/60 font-semibold">hari telat</p>
                                        </div>
                                    @elseif ($belumDiambil)
                                        <div class="text-center mb-1">
                                            <div class="flex items-center gap-1.5 bg-primary/5 border border-primary/20 rounded-xl px-3 py-2">
                                                <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a48.667 48.667 0 0 1 12 0m-12 0V6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v3.349M6.75 21V16.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21"/>
                                                </svg>
                                                <div class="text-left">
                                                    <p class="text-[10px] text-primary font-bold leading-none">Ambil di perpus</p>
                                                    <p class="text-[10px] text-primary/60 leading-none mt-0.5">{{ $hariMenunggu === 0 ? 'hari ini' : $hariMenunggu . ' hari lagi' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($sisaHari !== null)
                                        <div class="text-center mb-1">
                                            <span class="text-2xl font-black {{ $sisaHari <= 3 ? 'text-orange-500' : 'text-text/60' }}">{{ $sisaHari }}</span>
                                            <p class="text-[10px] {{ $sisaHari <= 3 ? 'text-orange-400' : 'text-text/30' }} font-semibold">hari lagi</p>
                                        </div>
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
                                            class="{{ $terlambat ? 'bg-secondary hover:bg-secondary/90' : 'bg-primary hover:bg-secondary' }} text-background pl-3 pr-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm hover:shadow">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                                            </svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-1.5 text-accent">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-xs font-semibold">Dikembalikan</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-background rounded-xl border border-dashed border-text/10">
                    <div class="flex justify-center mb-4">
                        <svg class="w-14 h-14 text-text/10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-text/50">Belum ada riwayat peminjaman</h3>
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
        /* ── Mini 3D Book for History ── */
        .hist-book-perspective {
            perspective: 700px;
        }
        .hist-book-3d {
            width: 68px;
            height: 96px;
            position: relative;
            transform-style: preserve-3d;
            transform: rotateY(-16deg) rotateX(2deg);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .group:hover .hist-book-3d {
            transform: rotateY(-22deg) rotateX(3deg) scale(1.05);
        }
        .hist-book-front {
            position: absolute;
            inset: 0;
            border-radius: 1px 6px 6px 1px;
            overflow: hidden;
            z-index: 10;
            background: var(--color-background);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .hist-book-pages {
            position: absolute;
            top: 3px; right: 0; bottom: 3px; left: 1px;
            background: #f5f5f0;
            border: 1px solid var(--color-text);
            border-color: color-mix(in srgb, var(--color-text) 10%, transparent);
            border-radius: 1px 5px 5px 1px;
            transform: translateZ(-4px) translateX(5px);
            z-index: 5;
        }
        .hist-book-pages::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(to right, transparent, transparent 1px, rgba(0,0,0,0.03) 1.5px, transparent 2.5px);
        }
        .hist-book-back {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, var(--color-text) 0%, var(--color-secondary) 100%);
            border-radius: 1px 6px 6px 1px;
            transform: translateZ(-8px) translateX(8px);
            box-shadow: 3px 5px 12px rgba(0,0,0,0.18);
            z-index: 1;
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

        switchTab('semua');
    </script>
@endsection
