@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-primary transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kategori</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-2xl mx-auto border border-gray-100">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-gray-700 uppercase mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-lg"
                    placeholder="Masukkan nama kategori" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-secondary to-primary text-background font-bold py-4 rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300 uppercase tracking-wider">
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
@endsection
