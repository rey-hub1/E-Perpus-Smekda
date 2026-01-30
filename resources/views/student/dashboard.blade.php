@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <div
            class="bg-primary text-white p-8 rounded-xl shadow-lg flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">

            <div class="relative z-10 text-center md:text-left w-full md:w-1/2">
                <h1 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="opacity-90">Mau baca buku apa hari ini?</p>
            </div>

            <div class="relative z-10 w-full md:w-1/2">
                <form action="{{ route('student.dashboard') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search"
                        class="w-full text-gray-800 p-3 rounded-lg focus:outline-none focus:ring-4 focus:ring-accent/50 shadow-inner"
                        placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">

                    <button type="submit"
                        class="bg-cta text-primary font-bold px-6 py-3 rounded-lg hover:bg-yellow-400 transition shadow-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow animate-fade-in-up">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow animate-fade-in-up">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (request('search'))
            <div class="flex justify-between items-center px-2">
                <p class="text-gray-500">Hasil pencarian: <span
                        class="font-bold text-primary">"{{ request('search') }}"</span></p>
                <a href="{{ route('student.dashboard') }}" class="text-red-500 text-sm hover:underline font-semibold">Reset
                    / Tampilkan Semua ✖</a>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse ($books as $book)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col h-full">

                    <div class="h-48 overflow-hidden bg-gray-200 relative group">
                        @if ($book->gambar)
                            <img src="/images/{{ $book->gambar }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                No Cover
                            </div>
                        @endif

                        <span class="absolute top-2 right-2 bg-cta text-primary text-xs font-bold px-2 py-1 rounded shadow">
                            Stok: {{ $book->stok }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-primary text-lg leading-tight mb-1 line-clamp-2">{{ $book->judul }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $book->penulis }}</p>

                        <div class="mt-auto">
                            <button onclick="openModal('{{ $book->id }}')"
                                class="w-full block text-center border-2 border-primary text-primary font-bold py-2 rounded-lg hover:bg-primary hover:text-white transition">
                                📖 Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-{{ $book->id }}" class="fixed inset-0 z-50 hidden">
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                        onclick="closeModal('{{ $book->id }}')"></div>

                    <div
                        class="relative bg-white w-full max-w-2xl mx-auto mt-20 rounded-xl shadow-2xl overflow-hidden animate-fade-in-up m-4">
                        <div class="flex flex-col md:flex-row">
                            <div class="w-full md:w-1/3 bg-gray-100 h-64 md:h-auto">
                                @if ($book->gambar)
                                    <img src="/images/{{ $book->gambar }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="w-full md:w-2/3 p-8 relative">
                                <button onclick="closeModal('{{ $book->id }}')"
                                    class="absolute top-4 right-4 text-gray-400 hover:text-red-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <h2 class="text-2xl font-bold text-primary mb-1">{{ $book->judul }}</h2>
                                <p class="text-secondary font-medium text-sm mb-4">Karya: {{ $book->penulis }} |
                                    {{ $book->penerbit }} ({{ $book->tahun_terbit }})</p>

                                <div class="border-t border-gray-100 py-4">
                                    <h4 class="font-bold text-gray-700 mb-2">Sinopsis:</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed h-40 overflow-y-auto pr-2">
                                        {{ $book->deskripsi ?? 'Belum ada sinopsis untuk buku ini.' }}
                                    </p>
                                </div>

                                <div class="mt-6 flex justify-end items-center gap-4">
                                    <span class="text-xs text-gray-500 font-medium">Sisa Stok: {{ $book->stok }}</span>

                                    @if ($book->stok > 0)
                                        <form action="{{ route('pinjam.buku', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-cta text-primary font-bold px-6 py-2 rounded-lg hover:bg-yellow-400 transition shadow-lg flex items-center gap-2">
                                                <span>📚</span> Pinjam Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <button disabled
                                            class="bg-gray-300 text-gray-500 font-bold px-6 py-2 rounded-lg cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    {{ $books->withQueryString()->links() }}
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-600">Buku tidak ditemukan</h3>
                    <p class="text-gray-400">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
    </style>
@endsection
