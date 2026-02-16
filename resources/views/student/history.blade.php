@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-cta flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-primary">Riwayat Peminjaman 📚</h1>
            <p class="text-gray-500 text-sm">Daftar buku yang sedang kamu pinjam dan yang sudah dikembalikan.</p>
        </div>

        <div class="text-right hidden md:block">
            <span class="block text-xs text-gray-400 uppercase font-bold tracking-wider">Sedang Dipinjam</span>
            <span class="text-2xl font-bold text-cta">{{ $transactions->where('status', 'dipinjam')->count() }} Buku</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow animate-fade-in-up">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow animate-fade-in-up">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-bold text-sm uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="p-4">Buku</th>
                        <th class="p-4">Tanggal Pinjam</th>
                        <th class="p-4">Tanggal Kembali</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($trx->book->gambar)
                                    <img src="/images/{{ $trx->book->gambar }}" class="w-10 h-14 object-cover rounded shadow-sm border border-gray-200">
                                @else
                                    <div class="w-10 h-14 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">No Cover</div>
                                @endif
                                <div>
                                    <div class="font-bold text-primary text-base">{{ $trx->book->judul }}</div>
                                    <div class="text-xs text-gray-400">{{ $trx->book->penulis }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </td>
                        <td class="p-4 text-gray-600">
                            @if($trx->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->translatedFormat('d F Y') }}
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            @if($trx->status == 'dipinjam')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200 shadow-sm">
                                    Sedang Dipinjam
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200 shadow-sm">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            @if($trx->status == 'dipinjam')
                                <form action="{{ route('buku.kembalikan', $trx->id) }}" method="POST" onsubmit="return confirm('Sudah selesai baca buku ini? Yakin mau dikembalikan?');">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-600 transition shadow hover:shadow-md transform hover:-translate-y-0.5">
                                        ⬅️ Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 font-medium">Selesai ✅</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500">
                            <div class="text-4xl mb-2">📭</div>
                            <p>Kamu belum meminjam buku apapun.</p>
                            <a href="{{ route('student.dashboard') }}" class="text-primary font-bold hover:underline mt-2 inline-block">Mulai Jelajah Buku &rarr;</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
