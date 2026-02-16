@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-primary">Laporan Transaksi 📋</h2>
                <p class="text-gray-500 text-sm">Pantau semua aktivitas peminjaman di sini.</p>
            </div>
            <a href="{{ route('admin.books.index') }}"
                class="bg-gray-100 text-primary px-4 py-2 rounded-lg hover:bg-gray-200 transition font-semibold">
                &larr; Kelola Buku
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Peminjam</th>
                        <th class="p-4">Buku</th>
                        <th class="p-4">Tgl Pinjam</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($transactions as $index => $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-500">{{ $index + 1 }}</td>
                            <td class="p-4">
                                <div class="font-bold text-primary">{{ $trx->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $trx->user->email }}</div>
                            </td>
                            <td class="p-4 font-medium text-gray-700">
                                {{ $trx->book->judul }}
                            </td>
                            <td class="p-4 text-sm">
                                {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                                <br>
                                <span class="text-xs text-gray-400">
                                    {{ $trx->tanggal_kembali ? 'Kembali: ' . \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') : 'Belum kembali' }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if ($trx->status == 'dipinjam')
                                    <span
                                        class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                        Dipinjam
                                    </span>
                                @else
                                    <span
                                        class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if ($trx->status == 'dipinjam')
                                    <form action="{{ route('admin.return', $trx->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau memproses pengembalian buku ini secara manual?')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-secondary text-white px-3 py-1 rounded text-xs font-bold hover:bg-primary transition shadow"
                                            title="Proses Pengembalian Manual">
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.pinjam', $trx->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau memproses peminjaman buku ini secara manual?')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-secondary text-white px-3 py-1 rounded text-xs font-bold hover:bg-primary transition shadow"
                                            title="Proses peminjaman Manual">
                                            Pinjam
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
