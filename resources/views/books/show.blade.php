@extends('layouts.app')

@section('title', $book->judul)

@section('content')
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-background">
        <div class="mx-auto">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-lg transition-all hover:scale-105 bg-secondary text-background hover:opacity-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-5 gap-8">
                    <div
                        class="md:col-span-2 p-8 book-card transition-all duration-500 bg-gradient-to-br from-primary to-secondary">
                        <div class="relative group">
                            @if ($book->gambar)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}"
                                    class="book-cover w-full h-auto rounded-lg shadow-2xl object-cover  transition-transform group-hover:scale-103"
                                    crossorigin="anonymous">
                            @else
                                <div class="w-full aspect-[3/4] bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                            @endif

                            @if ($book->favorite)
                                <div
                                    class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full p-3 shadow-lg text-accent">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class=" mt-6">
                            @if (session('error'))
                                <form action="{{ route('pinjam.buku', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-600 text-background  px-5 font-bold text-xl p-2 rounded-xl w-full">
                                        {{ session('error') }}

                                    </button>
                                @else
                                </form>
                                <form action="{{ route('pinjam.buku', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-primary text-background px-5 font-bold text-xl p-2 rounded-xl w-full">

                                        Pinjam
                                        Buku
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>

                    <div class="md:col-span-3 p-8">
                        <h1 class="text-4xl font-bold mb-6 leading-tight text-gray-900">
                            {{ $book->judul }}
                        </h1>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-start gap-3">
                                <div class="p-2 rounded-lg bg-white shadow-sm text-primary">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Penulis</p>
                                    <p class="font-semibold text-gray-900">{{ $book->penulis }}</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-start gap-3">
                                <div class="p-2 rounded-lg bg-white shadow-sm text-accent">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Penerbit</p>
                                    <p class="font-semibold text-gray-900">{{ $book->penerbit }}</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-start gap-3">
                                <div class="p-2 rounded-lg bg-white shadow-sm text-secondary">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Tahun</p>
                                    <p class="font-semibold text-gray-900">{{ $book->tahun_terbit }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="h-px my-6 bg-primary/20"></div>

                        <div class="mb-8">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">
                                Deskripsi Buku
                            </h2>
                            <div class="prose max-w-none text-lg leading-relaxed text-gray-600">
                                <p>
                                    {{ Str::limit($book->deskripsi ?? 'Tidak ada deskripsi.', 250) }}
                                </p>

                                @if (strlen($book->deskripsi) > 250)
                                    <button onclick="toggleModal('descriptionModal')"
                                        class="mt-2 text-sm font-semibold hover:underline focus:outline-none text-primary">
                                        Baca Selengkapnya &rarr;
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 p-6 rounded-xl border border-gray-100 bg-gray-50">
                            <h3 class="font-semibold mb-4 text-gray-900">Detail Buku</h3>
                            <div class="grid sm:grid-cols-2 gap-y-3 gap-x-8 text-sm">
                                <div class="flex flex-col gap-2">
                                    <div class="">
                                        <p class="text-text/70">Penerbit</p>
                                        <p class="text-text font-medium">Gramedia</p>
                                    </div>
                                    <div class="">
                                        <p class="text-text/70">ISBN</p>
                                        <p class="text-text font-medium">9786020633176</p>
                                    </div>
                                    <div class="">
                                        <p class="text-text/70">Bahasa</p>
                                        <p class="text-text font-medium">Indonesia</p>
                                    </div>
                                    <div class="">
                                        <p class="text-text/70">Lebar</p>
                                        <p class="text-text font-medium">15.0 cm</p>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <div class="">
                                        <p class="text-text/70">Tanggal Terbit</p>
                                        <p class="text-text font-medium">16 Sep 2019
                                        </p>
                                    </div>
                                    <div class="">
                                        <p class="text-text/70">

                                            Halaman</p>
                                        <p class="text-text font-medium">352
                                        </p>
                                    </div>
                                    <div class="">
                                        <p class="text-text/70">
                                            Panjang</p>
                                        <p class="text-text font-medium">23.0 cm
                                        </p>
                                    </div>
                                    <div class="">
                                        <p class="text-text/70">
                                            Berat</p>
                                        <p class="text-text font-medium">0.65 kg

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="descriptionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" onclick="toggleModal('descriptionModal')"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">Deskripsi Lengkap
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $book->judul }}</p>
                        </div>
                    </div>
                    <button onclick="toggleModal('descriptionModal')"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="bg-white px-4 py-6 sm:p-6 max-h-[60vh] overflow-y-auto">
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {{ $book->deskripsi }}
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" onclick="toggleModal('descriptionModal')"
                        class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto hover:opacity-90 transition-opacity bg-secondary">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi Toggle Modal
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengambil warna dominan & update background
            // Script ini tetap diperlukan untuk efek dinamis menyesuaikan warna cover buku
            function getDominantColor(imgElement, callback) {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = imgElement.naturalWidth || imgElement.width;
                canvas.height = imgElement.naturalHeight || imgElement.height;
                ctx.drawImage(imgElement, 0, 0, canvas.width, canvas.height);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;
                const colorCount = {};
                let maxCount = 0;
                let dominantColor = {
                    r: 221,
                    g: 161,
                    b: 94
                };

                for (let i = 0; i < data.length; i += 40) {
                    const r = data[i];
                    const g = data[i + 1];
                    const b = data[i + 2];
                    const a = data[i + 3];
                    if (a < 125) continue;
                    const roundedR = Math.round(r / 10) * 10;
                    const roundedG = Math.round(g / 10) * 10;
                    const roundedB = Math.round(b / 10) * 10;
                    const key = `${roundedR},${roundedG},${roundedB}`;
                    colorCount[key] = (colorCount[key] || 0) + 1;
                    if (colorCount[key] > maxCount) {
                        maxCount = colorCount[key];
                        dominantColor = {
                            r: roundedR,
                            g: roundedG,
                            b: roundedB
                        };
                    }
                }
                callback(dominantColor);
            }

            function darkenColor(color, percent) {
                return {
                    r: Math.round(color.r * (1 - percent)),
                    g: Math.round(color.g * (1 - percent)),
                    b: Math.round(color.b * (1 - percent))
                };
            }

            function applyGradientBackground(card, color) {
                const darkerColor = darkenColor(color, 0.3);
                const darkestColor = darkenColor(color, 0.5);
                // Script ini akan menimpa class Tailwind saat gambar selesai dimuat untuk efek yang lebih personal
                const gradient =
                    `linear-gradient(135deg, rgba(${color.r}, ${color.g}, ${color.b}, 0.8) 0%, rgba(${darkerColor.r}, ${darkerColor.g}, ${darkerColor.b}, 0.9) 50%, rgba(${darkestColor.r}, ${darkestColor.g}, ${darkestColor.b}, 1) 100%)`;
                card.style.background = gradient;
            }

            const bookCard = document.querySelector('.book-card');
            if (bookCard) {
                const img = bookCard.querySelector('.book-cover');
                if (img) {
                    if (img.complete) {
                        getDominantColor(img, (color) => {
                            applyGradientBackground(bookCard, color);
                        });
                    } else {
                        img.addEventListener('load', function() {
                            getDominantColor(img, (color) => {
                                applyGradientBackground(bookCard, color);
                            });
                        });
                        img.addEventListener('error', function() {
                            console.log('Failed to load image');
                        });
                    }
                }
            }
        });
    </script>
@endsection
