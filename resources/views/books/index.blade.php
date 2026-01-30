@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-secondary">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-primary">Koleksi Buku 📖</h2>

            <a href="{{ route('books.create') }}"
                class="bg-cta text-primary font-bold px-6 py-2 rounded-full hover:bg-yellow-400 transition shadow flex items-center gap-2">
                + Tambah Buku
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-accent/20 border border-accent text-primary p-4 rounded-lg mb-6">
                ✅ {{ $message }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th class="p-4">Cover</th>
                        <th class="p-4">Judul & Penulis</th>
                        <th class="p-4 text-center">Tahun</th>
                        <th class="p-4 text-center">Stok</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($books as $book)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 w-24">
                                @if ($book->gambar)
                                    <img src="/images/{{ $book->gambar }}" class="w-16 h-24 object-cover rounded shadow-sm">
                                @else
                                    <div
                                        class="w-16 h-24 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                                        No Cover</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-lg text-primary">{{ $book->judul }}</div>
                                <div class="text-sm text-gray-500">{{ $book->penulis }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $book->penerbit }}</div>
                            </td>
                            <td class="p-4 text-center font-medium">{{ $book->tahun_terbit }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-accent/30 text-primary px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $book->stok }}
                                </span>`
                            </td>
                            <td class="p-4 text-center flex justify-center gap-2">
                                <a href="{{ route('books.edit', $book->id) }}"
                                    class="text-secondary hover:text-primary font-semibold text-sm transition">
                                    ✏️ Edit
                                </a>

                                <span class="text-gray-300">|</span>

                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau menghapus buku {{ $book->judul }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-semibold text-sm transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection
