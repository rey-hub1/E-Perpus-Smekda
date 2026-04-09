@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')
@section('page-subtitle', 'Atur kategori buku untuk mempermudah pencarian')

@section('content')
<div class="space-y-5">

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

    @if (session('error'))
        <div class="bg-background border border-text/10 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-background" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <span class="text-text font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-end">
        <a href="{{ route('admin.categories.create') }}"
            class="flex items-center gap-2 bg-primary text-background font-semibold px-4 py-2.5 rounded-lg text-sm hover:bg-secondary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Kategori
        </a>
    </div>

    <div class="bg-background rounded-xl border border-text/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-text/5">
            <p class="text-sm font-semibold text-text">Daftar Kategori</p>
            <p class="text-xs text-text/40 mt-0.5">{{ count($categories) }} kategori tersedia</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-text/5 bg-text/2">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-text/40 uppercase tracking-wider">Jumlah Buku</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-text/40 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-text/5">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-text/2 transition-colors">

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-primary/8 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-text">{{ $category->name }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="inline-block text-xs font-semibold text-text/50 bg-text/5 px-3 py-1 rounded-full">
                                    {{ $category->books_count ?? $category->books()->count() }} buku
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="text-xs font-semibold text-text/60 border border-text/10 bg-background hover:border-text/20 px-3 py-1.5 rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs font-semibold text-secondary border border-secondary/10 bg-secondary/5 hover:bg-secondary/10 px-3 py-1.5 rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-text/10 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3z"/>
                                </svg>
                                <p class="text-sm text-text/30">Belum ada kategori. Tambahkan kategori pertama.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
