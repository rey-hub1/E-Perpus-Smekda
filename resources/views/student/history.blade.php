@extends('layouts.app')

@section('title', 'Riwayat Pinjam')

@section('content')
    @php
        $dipinjam       = $transactions->where('status', 'dipinjam');
        $dikembalikan   = $transactions->where('status', 'dikembalikan');
        $terlambatCount = $dipinjam->filter(fn($t) =>
            $t->due_date && \Carbon\Carbon::now()->gt($t->due_date)
        )->count();
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-text">Buku Saya</h1>
                <p class="text-sm text-text/50 mt-1">Kelola peminjaman dan riwayat bacaanmu.</p>
            </div>

            {{-- Stats ringkas --}}
            <div class="flex gap-3">
                <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2">
                    <span class="text-lg font-black text-yellow-600">{{ $dipinjam->count() }}</span>
                    <span class="text-xs font-semibold text-yellow-700">Dipinjam</span>
                </div>
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                    <span class="text-lg font-black text-green-600">{{ $dikembalikan->count() }}</span>
                    <span class="text-xs font-semibold text-green-700">Selesai</span>
                </div>
                @if ($terlambatCount > 0)
                    <div class="flex items-center gap-2 bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                        <span class="text-lg font-black text-red-600">{{ $terlambatCount }}</span>
                        <span class="text-xs font-semibold text-red-700">Terlambat</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tab Filter --}}
        <div class="flex gap-1 bg-gray-100 p-1 rounded-lg w-fit" id="tabContainer">
            <button onclick="switchTab('semua')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-md transition-all"
                data-tab="semua">
                Semua ({{ $transactions->count() }})
            </button>
            <button onclick="switchTab('dipinjam')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-md transition-all"
                data-tab="dipinjam">
                Dipinjam ({{ $dipinjam->count() }})
            </button>
            <button onclick="switchTab('dikembalikan')"
                class="tab-btn px-4 py-2 text-sm font-semibold rounded-md transition-all"
                data-tab="dikembalikan">
                Selesai ({{ $dikembalikan->count() }})
            </button>
        </div>

        {{-- Book Cards --}}
        <div class="space-y-3" id="bookList">
            @forelse ($transactions as $trx)
                @php
                    $terlambat    = $trx->status === 'dipinjam' && $trx->due_date && \Carbon\Carbon::now()->gt($trx->due_date);
                    $hariTelat    = $terlambat ? (int) \Carbon\Carbon::now()->diffInDays($trx->due_date) : 0;
                    $estimasiDenda = $hariTelat * 1000;
                    $sisaHari     = !$terlambat && $trx->status === 'dipinjam' && $trx->due_date
                                    ? (int) \Carbon\Carbon::now()->diffInDays($trx->due_date, false)
                                    : null;
                @endphp

                <div class="book-item bg-white rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-md transition-all duration-200 overflow-hidden"
                     data-status="{{ $trx->status }}">
                    <div class="flex flex-col sm:flex-row">

                        {{-- Cover --}}
                        <a href="{{ route('book.show', $trx->book->slug) }}"
                            class="shrink-0 sm:w-[100px] h-[140px] sm:h-auto bg-gray-100 overflow-hidden group">
                            @if ($trx->book->gambar)
                                <img src="{{ $trx->book->cover_url }}" alt="{{ $trx->book->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </a>

                        {{-- Content --}}
                        <div class="flex-1 p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center gap-4">

                            {{-- Info Buku --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-2 mb-1">
                                    <a href="{{ route('book.show', $trx->book->slug) }}"
                                       class="font-bold text-text text-base leading-tight line-clamp-1 hover:text-primary transition-colors">
                                        {{ $trx->book->judul }}
                                    </a>
                                    @if ($trx->status === 'dipinjam')
                                        @if ($terlambat)
                                            <span class="shrink-0 text-[10px] font-bold bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Terlambat {{ $hariTelat }} hari</span>
                                        @else
                                            <span class="shrink-0 text-[10px] font-bold bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Dipinjam</span>
                                        @endif
                                    @else
                                        <span class="shrink-0 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Selesai</span>
                                    @endif
                                </div>
                                <p class="text-sm text-text/50 mb-3">{{ $trx->book->penulis }}</p>

                                {{-- Timeline info --}}
                                <div class="flex flex-wrap gap-x-5 gap-y-1 text-xs text-text/40">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Pinjam: {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->translatedFormat('d M Y') }}</span>
                                    </div>

                                    @if ($trx->due_date)
                                        <div class="flex items-center gap-1.5 {{ $terlambat ? 'text-red-500 font-semibold' : '' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Tempo: {{ \Carbon\Carbon::parse($trx->due_date)->translatedFormat('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if ($trx->tanggal_kembali)
                                        <div class="flex items-center gap-1.5 text-green-600">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Kembali: {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->translatedFormat('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if ($trx->fine > 0)
                                        <div class="flex items-center gap-1.5 text-red-500 font-semibold">
                                            <span>Denda: Rp{{ number_format($trx->fine, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Action / Right side --}}
                            <div class="shrink-0 flex flex-col items-end gap-2">
                                @if ($trx->status === 'dipinjam')
                                    {{-- Sisa hari --}}
                                    @if ($terlambat)
                                        <div class="text-center mb-1">
                                            <span class="text-2xl font-black text-red-500">-{{ $hariTelat }}</span>
                                            <p class="text-[10px] text-red-400 font-semibold">hari</p>
                                        </div>
                                    @elseif ($sisaHari !== null)
                                        <div class="text-center mb-1">
                                            <span class="text-2xl font-black {{ $sisaHari <= 3 ? 'text-orange-500' : 'text-text/70' }}">{{ $sisaHari }}</span>
                                            <p class="text-[10px] {{ $sisaHari <= 3 ? 'text-orange-400' : 'text-text/40' }} font-semibold">hari lagi</p>
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
                                            class="{{ $terlambat ? 'bg-red-500 hover:bg-red-600' : 'bg-primary hover:bg-secondary' }} text-white pl-3 pr-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm hover:shadow">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                                            </svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-1.5 text-green-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-semibold">Dikembalikan</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-xl border border-dashed border-gray-200">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-lg font-bold text-text/60">Belum ada riwayat peminjaman</h3>
                    <p class="text-sm text-text/40 mt-1">Kamu belum meminjam buku apapun.</p>
                    <a href="{{ route('student.home') }}"
                        class="mt-4 inline-flex items-center gap-2 bg-primary text-white font-bold text-sm px-5 py-2.5 rounded-lg hover:bg-secondary transition shadow-sm">
                        Jelajah Buku
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Empty state per tab (hidden by default) --}}
        <div id="emptyTab" class="hidden text-center py-16">
            <p class="text-sm text-text/40 font-medium">Tidak ada buku di kategori ini.</p>
        </div>

    </div>

    <script>
        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-text', 'shadow-sm');
                btn.classList.add('text-text/50');
                if (btn.dataset.tab === tab) {
                    btn.classList.add('bg-white', 'text-text', 'shadow-sm');
                    btn.classList.remove('text-text/50');
                }
            });

            // Filter items
            const items = document.querySelectorAll('.book-item');
            let visibleCount = 0;
            items.forEach(item => {
                if (tab === 'semua' || item.dataset.status === tab) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide empty state
            document.getElementById('emptyTab').classList.toggle('hidden', visibleCount > 0 || items.length === 0);
        }

        // Init: activate "semua" tab
        switchTab('semua');
    </script>
@endsection
