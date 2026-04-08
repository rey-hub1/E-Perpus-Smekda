@extends('layouts.admin')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Pantau semua aktivitas peminjaman buku')

@section('content')
<div class="space-y-5">

    @if (session('success'))
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-gray-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <span class="text-gray-700 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-900">Daftar Transaksi</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $transactions->count() }} total entri</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-8">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Peminjam</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Buku</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Jadwal</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Denda</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($transactions as $index => $trx)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-5 py-4 text-gray-400 text-xs">{{ $index + 1 }}</td>

                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900">{{ $trx->user->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $trx->user->email }}</p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-700 leading-snug">{{ Str::limit($trx->book->judul, 35) }}</p>
                            </td>

                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
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
                                    <div class="flex items-center gap-1.5 text-xs text-gray-400">
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
                                    <span class="text-primary font-bold text-xs">Rp{{ number_format($trx->fine, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if ($trx->status == 'dipinjam')
                                    <span class="inline-block bg-red-50 text-primary text-xs font-semibold px-2.5 py-1 rounded-full border border-red-100">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
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
                                            class="bg-white border border-gray-200 text-gray-700 hover:border-primary hover:text-primary text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.pinjam', $trx->id) }}" method="POST"
                                        onsubmit="return confirm('Proses peminjaman buku ini secara manual?')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-white border border-gray-200 text-gray-700 hover:border-primary hover:text-primary text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                            Pinjamkan
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
                                </svg>
                                <p class="text-sm text-gray-400">Belum ada transaksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
