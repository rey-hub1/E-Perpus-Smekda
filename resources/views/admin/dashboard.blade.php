@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-primary">Dashboard Admin 📊</h1>
            <p class="text-gray-500">Selamat datang kembali, {{ Auth::user()->name }}.</p>
        </div>
        <div class="text-sm text-gray-400">
            {{ now()->format('l, d F Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-primary flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Koleksi</p>
                <h3 class="text-3xl font-bold text-primary">{{ $totalBuku }}</h3>
            </div>
            <div class="bg-primary/10 p-3 rounded-full text-primary text-2xl">📚</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-secondary flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Siswa Terdaftar</p>
                <h3 class="text-3xl font-bold text-secondary">{{ $totalSiswa }}</h3>
            </div>
            <div class="bg-secondary/10 p-3 rounded-full text-secondary text-2xl">👨‍🎓</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-cta flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Sedang Dipinjam</p>
                <h3 class="text-3xl font-bold text-yellow-600">{{ $sedangDipinjam }}</h3>
            </div>
            <div class="bg-cta/20 p-3 rounded-full text-yellow-700 text-2xl">⏳</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-accent flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Sirkulasi</p>
                <h3 class="text-3xl font-bold text-accent">{{ $totalTransaksi }}</h3>
            </div>
            <div class="bg-accent/20 p-3 rounded-full text-green-700 text-2xl">📈</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="bg-white p-6 rounded-xl shadow-lg h-fit">
            <h3 class="font-bold text-primary mb-4 text-lg">Aksi Cepat 🚀</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.books.create') }}" class="block w-full text-center bg-primary text-white py-3 rounded-lg font-bold hover:bg-secondary transition shadow">
                    + Tambah Buku Baru
                </a>
                <a href="{{ route('admin.books.index') }}" class="block w-full text-center border-2 border-primary text-primary py-3 rounded-lg font-bold hover:bg-primary hover:text-white transition">
                    Kelola Data Buku
                </a>
                <a href="{{ route('admin.transactions') }}" class="block w-full text-center border-2 border-cta text-yellow-700 py-3 rounded-lg font-bold hover:bg-cta transition">
                    Lihat Semua Laporan
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="font-bold text-primary mb-4 text-lg">Aktivitas Terbaru 🕒</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-sm border-b border-gray-100">
                            <th class="pb-2 font-medium">Siswa</th>
                            <th class="pb-2 font-medium">Buku</th>
                            <th class="pb-2 font-medium">Waktu</th>
                            <th class="pb-2 font-medium text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($latestTransactions as $trx)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 font-medium text-primary">{{ $trx->user->name }}</td>
                            <td class="py-3 text-gray-600">{{ Str::limit($trx->book->judul, 25) }}</td>
                            <td class="py-3 text-gray-400">{{ $trx->created_at->diffForHumans() }}</td>
                            <td class="py-3 text-center">
                                @if($trx->status == 'dipinjam')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-bold">Pinjam</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Kembali</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
