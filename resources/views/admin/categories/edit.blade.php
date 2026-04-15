@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui nama kategori')

@section('content')
<div class="max-w-xl">

    <a href="{{ route('admin.categories.index') }}"
        class="inline-flex items-center gap-2 text-sm text-text/40 hover:text-text mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Kategori
    </a>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold text-text/40 uppercase tracking-wider">Informasi Kategori</p>
        </div>
        <div class="px-6 py-5">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-text mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" id="name"
                        placeholder="Masukkan nama kategori"
                        class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 justify-end pt-2 border-t border-gray-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-text/50 hover:text-text transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
