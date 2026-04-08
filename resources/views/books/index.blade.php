@extends('layouts.admin')

@section('title', 'Koleksi Buku')
@section('page-title', 'Koleksi Buku')
@section('page-subtitle', 'Kelola dan organisir koleksi perpustakaan')

@section('content')
<div class="space-y-5">

    @if (session('success'))
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-gray-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Judul</p>
            <p class="text-2xl font-bold text-gray-900">{{ $books->total() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Stok</p>
            <p class="text-2xl font-bold text-gray-900">{{ $books->sum('stok') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Buku Unggulan</p>
            <p class="text-2xl font-bold text-primary">{{ \App\Models\Book::where('featured', true)->count() }}</p>
        </div>
    </div>

    <!-- Search + Add -->
    <div class="flex gap-3">
        <form action="{{ route('admin.books.index') }}" method="GET" class="flex gap-2 flex-1">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul atau penulis..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2.5 bg-white border border-gray-200 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
        <a href="{{ route('admin.books.create') }}"
            class="flex items-center gap-2 bg-primary text-white font-semibold px-4 py-2.5 rounded-lg text-sm hover:bg-red-700 transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Buku
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cover</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Informasi Buku</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Tahun</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Unggulan</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-5 py-4 w-24">
                                @if ($book->gambar)
                                    <img src="{{ $book->cover_url }}" class="w-12 h-16 object-cover rounded-lg border border-gray-100 shadow-sm" alt="{{ $book->judul }}">
                                @else
                                    <div class="w-12 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900 leading-snug">{{ $book->judul }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $book->penulis }}</p>
                                <p class="text-xs text-gray-400">{{ $book->penerbit }}</p>
                                @if($book->category)
                                    <span class="inline-block mt-1.5 text-[10px] font-semibold text-primary bg-red-50 px-2 py-0.5 rounded-full">{{ $book->category->name }}</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="text-sm font-medium text-gray-600">{{ $book->tahun_terbit }}</span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if ($book->stok > 5)
                                    <span class="inline-block text-xs font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-full">{{ $book->stok }}</span>
                                @elseif ($book->stok > 0)
                                    <span class="inline-block text-xs font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full">{{ $book->stok }}</span>
                                @else
                                    <span class="inline-block text-xs font-bold text-primary bg-red-50 px-3 py-1 rounded-full">Habis</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                <form action="{{ route('admin.books.featured', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors" title="{{ $book->featured ? 'Hapus dari unggulan' : 'Jadikan unggulan' }}">
                                        @if ($book->featured)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                        class="text-xs font-semibold text-gray-600 border border-gray-200 bg-white hover:border-gray-300 px-3 py-1.5 rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus buku ini? Tindakan tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs font-semibold text-primary border border-red-100 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                                </svg>
                                <p class="text-sm text-gray-400">Belum ada buku di koleksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                {{ $books->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
