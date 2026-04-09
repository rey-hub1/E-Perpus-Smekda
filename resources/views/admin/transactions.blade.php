@extends('layouts.admin')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Pantau semua aktivitas peminjaman buku')

@section('content')
<div class="space-y-5">

    @if (session('success'))
        <div class="bg-background border border-text/10 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-accent flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-background" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-text font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-background border border-text/10 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-background" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <span class="text-text font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Konfirmasi Pengembalian via Kode -->
    <div class="bg-background border border-text/10 rounded-xl p-5">
        <div class="flex items-start gap-4">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background: #DC2626;">
                <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text">Konfirmasi Pengembalian</p>
                <p class="text-xs text-text/40 mt-0.5">Masukkan kode yang ditunjukkan siswa untuk memproses pengembalian buku.</p>
                <form action="{{ route('admin.return.by-code') }}" method="POST" class="flex items-center gap-3 mt-3">
                    @csrf
                    <input type="text" name="return_code"
                        placeholder="KMB-XXXXXX"
                        value="{{ old('return_code') }}"
                        maxlength="10"
                        class="uppercase tracking-widest font-mono text-sm border border-text/10 rounded-lg px-4 py-2 w-44 focus:outline-none focus:border-primary bg-white text-text placeholder:text-text/30 placeholder:normal-case placeholder:tracking-normal"
                        style="font-family: monospace;"
                        oninput="this.value = this.value.toUpperCase()">
                    <button type="submit"
                        class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-secondary transition-colors">
                        Proses Pengembalian
                    </button>
                </form>
                @error('return_code')
                    <p class="text-xs text-primary mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-background rounded-xl border border-text/10 overflow-hidden">

        <div class="px-6 py-4 border-b border-text/5 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-text">Daftar Transaksi</p>
                <p class="text-xs text-text/40 mt-0.5">{{ $transactions->count() }} total entri</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-text/5 bg-text/2">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider w-8">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Peminjam</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Buku</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Jadwal</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-text/40 uppercase tracking-wider">Denda</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-text/40 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-text/40 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-text/5">
                    @forelse ($transactions as $index => $trx)
                        <tr class="hover:bg-text/2 transition-colors">
                            <td class="px-5 py-4 text-text/40 text-xs">{{ $index + 1 }}</td>

                            <td class="px-5 py-4">
                                <p class="font-semibold text-text">{{ $trx->user->name }}</p>
                                <p class="text-xs text-text/40 mt-0.5">{{ $trx->user->email }}</p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-text/70 leading-snug">{{ Str::limit($trx->book->judul, 35) }}</p>
                            </td>

                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 text-xs text-text/50">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                        </svg>
                                        Ambil: {{ $trx->tanggal_ambil ? \Carbon\Carbon::parse($trx->tanggal_ambil)->format('d M Y') : \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                                    </div>
                                    @if($trx->due_date)
                                    <div class="flex items-center gap-1.5 text-xs text-primary">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                        </svg>
                                        Tempo: {{ \Carbon\Carbon::parse($trx->due_date)->format('d M Y') }}
                                    </div>
                                    @endif
                                    @if($trx->tanggal_kembali)
                                    <div class="flex items-center gap-1.5 text-xs text-text/40">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                        </svg>
                                        Kembali: {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if($trx->fine > 0)
                                    <span class="text-secondary font-bold text-xs">Rp{{ number_format($trx->fine, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-text/30 text-xs">—</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if ($trx->status == 'dipinjam')
                                    <span class="inline-block bg-primary/10 text-primary text-xs font-semibold px-2.5 py-1 rounded-full border border-primary/10">
                                        Dipinjam
                                    </span>
                                @elseif ($trx->status == 'mengembalikan')
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="inline-block bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200">
                                            Mengembalikan
                                        </span>
                                        @if ($trx->return_code)
                                            <span class="text-[10px] font-mono font-bold text-amber-600 tracking-widest">{{ $trx->return_code }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-block bg-text/5 text-text/50 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if ($trx->status == 'dipinjam')
                                    <form action="{{ route('admin.return', $trx->id) }}" method="POST"
                                        onsubmit="return confirm('Proses pengembalian buku ini secara manual?')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-background border border-text/10 text-text/70 hover:border-primary hover:text-primary text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                            Manual
                                        </button>
                                    </form>
                                @elseif ($trx->status == 'mengembalikan')
                                    <span class="text-[11px] text-amber-600 font-medium">Tunggu kode</span>
                                @else
                                    <form action="{{ route('admin.pinjam', $trx->id) }}" method="POST"
                                        onsubmit="return confirm('Proses peminjaman buku ini secara manual?')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-background border border-text/10 text-text/70 hover:border-primary hover:text-primary text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                            Pinjamkan
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-text/10 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
                                </svg>
                                <p class="text-sm text-text/40">Belum ada transaksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
