@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Konfigurasi sistem perpustakaan')

@section('content')
<div class="space-y-5 max-w-xl">

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

    <!-- Pengaturan Peminjaman -->
    <div class="bg-background border border-text/10 rounded-xl p-5">
        <div class="flex items-start gap-4">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background: #DC2626;">
                <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text">Durasi Peminjaman</p>
                <p class="text-xs text-text/40 mt-0.5">Atur berapa hari siswa boleh meminjam buku sebelum batas pengembalian.</p>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input
                                type="number"
                                name="loan_days"
                                value="{{ old('loan_days', $loanDays) }}"
                                min="1"
                                max="365"
                                class="w-24 border border-text/10 rounded-lg px-4 py-2 text-sm text-text bg-white focus:outline-none focus:border-primary
                                    @error('loan_days') border-primary @enderror"
                            >
                        </div>
                        <span class="text-sm text-text/50">hari</span>
                        <button type="submit"
                            class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-secondary transition-colors ml-1">
                            Simpan
                        </button>
                    </div>

                    @error('loan_days')
                        <p class="text-xs text-primary mt-1.5">{{ $message }}</p>
                    @enderror
                </form>

                <p class="text-xs text-text/30 mt-3">
                    Saat ini: <span class="font-semibold text-text/50">{{ $loanDays }} hari</span>
                    &mdash; Berlaku untuk semua peminjaman baru.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
