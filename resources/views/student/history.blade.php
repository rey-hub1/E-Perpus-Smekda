@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        {{-- Hero Header sama seperti home page --}}
        <div
            class="bg-primary text-white p-8 rounded-xl shadow-lg flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">

            <div class="relative z-10 text-center md:text-left">
                <h1 class="text-3xl font-bold mb-2">Riwayat Peminjaman 📚</h1>
                <p class="opacity-90">Daftar buku yang sedang kamu pinjam dan yang sudah dikembalikan.</p>
            </div>

            <div class="relative z-10 text-right hidden md:block">
                <span class="block text-xs text-white/60 uppercase font-bold tracking-wider mb-1">Sedang Dipinjam</span>
                <span class="text-4xl font-bold text-cta">{{ $transactions->where('status', 'dipinjam')->count() }}</span>
                <span class="text-white/80 ml-1 text-lg">Buku</span>
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

        <div class="rounded-xl shadow-lg overflow-hidden border border-gray-100 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-white text-sm uppercase tracking-wider bg-primary">
                        <tr>
                            <th class="p-4">Buku</th>
                            <th class="p-4">Tanggal Pinjam</th>
                            <th class="p-4">Tanggal Kembali</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @if ($trx->book->gambar)
                                            <img src="/images/{{ $trx->book->gambar }}"
                                                class="h-24 object-cover rounded-r-lg shadow-md border border-gray-200 transition duration-300 hover:scale-105">
                                        @else
                                            <div
                                                class="w-10 h-14 rounded flex items-center justify-center text-xs text-white font-bold bg-gradient-to-br from-blue-900 to-blue-700">
                                                N/A
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-primary text-lg leading-tight">
                                                {{ $trx->book->judul }}</div>
                                            <div class="text-sm text-gray-400 mt-0.5">{{ $trx->book->penulis }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->translatedFormat('d F Y') }}
                                </td>

                                <td class="p-4 text-gray-600">
                                    @if ($trx->tanggal_kembali)
                                        {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->translatedFormat('d F Y') }}
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    @if ($trx->status == 'dipinjam')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200 shadow-sm">
                                            Sedang Dipinjam
                                        </span>
                                    @else
                                        <span
                                            class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200 shadow-sm">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    @if ($trx->status == 'dipinjam')
                                        <form action="{{ route('buku.kembalikan', $trx->id) }}" method="POST"
                                            onsubmit="return confirm('Sudah selesai baca buku ini? Yakin mau dikembalikan?');">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-4 py-2 flex items-center gap-2 justify-center mx-auto rounded-lg text-xs font-bold hover:bg-red-600 transition shadow hover:shadow-md transform hover:-translate-y-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-arrow-left-icon lucide-arrow-left">
                                                    <path d="m12 19-7-7 7-7" />
                                                    <path d="M19 12H5" />
                                                </svg> Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 font-medium">Selesai ✅</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="text-center py-20">
                                        <div class="text-6xl mb-4">📭</div>
                                        <h3 class="text-xl font-bold text-gray-600">Belum ada riwayat peminjaman</h3>
                                        <p class="text-gray-400 mt-1">Kamu belum meminjam buku apapun.</p>
                                        <a href="{{ route('student.home') }}"
                                            class="mt-4 inline-block bg-primary text-white font-bold px-6 py-2 rounded-lg hover:opacity-90 transition shadow">
                                            Mulai Jelajah Buku &rarr;
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

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
