@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas perpustakaan')

@section('content')
<div class="space-y-6">

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Koleksi</p>
                <div class="w-8 h-8 bg-primary/8 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalBuku }}</p>
            <p class="text-xs text-gray-400 mt-1">judul buku</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa Terdaftar</p>
                <div class="w-8 h-8 bg-primary/8 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalSiswa }}</p>
            <p class="text-xs text-gray-400 mt-1">anggota aktif</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sedang Dipinjam</p>
                <div class="w-8 h-8 bg-primary/8 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-primary">{{ $sedangDipinjam }}</p>
            <p class="text-xs text-gray-400 mt-1">buku keluar</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sirkulasi</p>
                <div class="w-8 h-8 bg-primary/8 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalTransaksi }}</p>
            <p class="text-xs text-gray-400 mt-1">total transaksi</p>
        </div>

    </div>

    <!-- Row 2: Quick Actions + Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.books.create') }}"
                    class="flex items-center gap-3 w-full bg-primary text-white px-4 py-3 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Tambah Buku Baru
                </a>
                <a href="{{ route('admin.books.index') }}"
                    class="flex items-center gap-3 w-full border border-gray-200 text-gray-700 px-4 py-3 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                    </svg>
                    Kelola Koleksi Buku
                </a>
                <a href="{{ route('admin.transactions') }}"
                    class="flex items-center gap-3 w-full border border-gray-200 text-gray-700 px-4 py-3 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
                    </svg>
                    Laporan Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 w-full border border-gray-200 text-gray-700 px-4 py-3 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z"/>
                    </svg>
                    Data Anggota
                </a>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Aktivitas Terbaru</h3>
                <a href="{{ route('admin.transactions') }}" class="text-xs text-primary font-medium hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($latestTransactions as $trx)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $trx->user->name }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ Str::limit($trx->book->judul, 28) }}</td>
                            <td class="px-6 py-3 text-gray-400 text-xs">{{ $trx->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-3 text-center">
                                @if($trx->status == 'dipinjam')
                                    <span class="inline-block bg-red-50 text-primary text-xs font-semibold px-2.5 py-1 rounded-full">Dipinjam</span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">Kembali</span>
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
