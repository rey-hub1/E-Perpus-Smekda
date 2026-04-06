@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Kategori</h1>
            <p class="text-sm text-gray-500">Atur kategori buku untuk mempermudah pencarian</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="bg-primary text-white font-semibold px-5 py-2 rounded-lg hover:bg-secondary transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="border-l-4 border-green-500 bg-green-50 text-green-700 p-5 rounded-lg mb-6 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="border-l-4 border-red-500 bg-red-50 text-red-700 p-5 rounded-lg mb-6 shadow-md">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-6 bg-gradient-to-r from-secondary to-primary text-background">
            <h3 class="text-xl font-bold">Daftar Kategori</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="p-5 text-left text-xs font-bold text-gray-600 uppercase">Nama Kategori</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Jumlah Buku</th>
                        <th class="p-5 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="p-5 font-semibold text-text">
                                {{ $category->name }}
                            </td>
                            <td class="p-5 text-center">
                                <span class="px-3 py-1 rounded-full bg-primary/20 text-text font-bold">
                                    {{ $category->books_count ?? $category->books()->count() }} Buku
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="px-4 py-2 rounded-lg bg-yellow-400 text-white text-sm font-medium hover:bg-yellow-500 transition-all">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-red-500 text-white text-sm font-medium hover:bg-red-600 transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
