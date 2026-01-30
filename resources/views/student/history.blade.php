@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-primary">Buku Saya 📚</h2>
            <p class="text-gray-500 text-sm">Riwayat peminjaman dan pengembalian buku.</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="text-secondary hover:underline">
            &larr; Kembali ke Katalog
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="p-4">Buku</th>
                    <th class="p-4">Tanggal Pinjam</th>
                    <th class="p-4">Tanggal Kembali</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($transactions as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="font-bold text-primary">{{ $trx->book->judul }}</div>
                        <div class="text-xs text-gray-400">{{ $trx->book->penulis }}</div>
                    </td>
                    <td class="p-4 text-sm">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}</td>
                    <td class="p-4 text-sm">
                        @if($trx->tanggal_kembali)
                            {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($trx->status == 'dipinjam')
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">
                                Sedang Dipinjam
                            </span>
                        @else
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                Sudah Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($trx->status == 'dipinjam')
                            <form action="{{ route('buku.kembalikan', $trx->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded text-sm font-bold hover:bg-red-600 transition shadow">
                                    Kembalikan
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">
                        Belum ada riwayat peminjaman. Ayo pinjam buku!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
