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
                <form action="{{ route('student.katalog') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search"
                        class="w-full text-gray-800 p-3 bg-background rounded-lg focus:outline-none focus:ring-4 focus:ring-accent/50 shadow-inner"
                        placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">

                    <button type="submit"
                        class="bg-cta text-primary font-bold px-6 py-3 rounded-lg bg-background hover:bg-yellow-400 transition shadow-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <div class="py-8">
            <h2 class="text-3xl font-bold">Buku Terpopuler</h2>

            <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide pt-6">
                @foreach ($NewBook as $NB)
                    <a href="{{ route('book.show', $NB->slug) }}" class="group shrink-0 group">
                        <div class="book-card relative w-[380px] h-[240px] rounded-2xl overflow-hidden shadow-lg  transition-all duration-300 "
                            style="background: linear-gradient(135deg, #334155 0%, #1e293b 100%);">

                            <!-- Book Cover Card - Positioned on the left -->
                            <div
                                class="absolute left-6 top-1/2 transition-all duration-300 group-hover:scale-103 -translate-y-1/2 w-[140px] h-[200px] bg-gradient-to-br from-blue-900 to-blue-700 rounded-r-lg shadow-2xl overflow-hidden z-10">
                                <!-- Book cover image -->
                                @if ($NB->gambar)
                                    <img src="{{ $NB->cover_url }}" alt="{{ $NB->judul }}"
                                        class="book-cover w-full h-full object-cover" crossorigin="anonymous">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center p-4 bg-gradient-to-br from-blue-900 to-blue-700">
                                        <p class="text-white text-center font-bold text-sm leading-tight">
                                            {{ $NB->judul }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Section -->
                            <div
                                class="absolute group-hover:translate-x-0.5 transition-all duration-200 right-0 top-0 w-[220px] h-full flex flex-col justify-center p-6 pl-8">
                                <h3 class="text-white text-2xl font-bold mb-4 leading-tight line-clamp-3">
                                    {{ $NB->judul }}
                                </h3>

                                <div class="space-y-2 text-slate-300 text-sm">
                                    <!-- Author/Category -->
                                    @if (isset($NB->penulis))
                                        <p class="flex items-center gap-2 ">
                                            <span class="font-semibold">{{ $NB->penulis }}</span>
                                        </p>
                                    @endif

                                    <!-- Pages/Info -->
                                    <p class="flex items-center gap-2">
                                        @if (isset($NB->halaman))
                                            <span>{{ $NB->halaman }} hal</span>
                                            <span>•</span>
                                        @endif
                                        @if (isset($NB->chapter))
                                            <span>{{ $NB->chapter }} Chapter</span>
                                        @endif
                                    </p>

                                    <!-- Category/Type -->
                                    @if (isset($NB->kategori))
                                        <p class="text-xs bg-white/10 backdrop-blur-sm px-3 py-1 rounded-full inline-block">
                                            {{ $NB->kategori }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Hover overlay effect -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </a>
                @endforeach
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
                <a href="{{ route('student.home') }}" class="text-red-500 text-sm hover:underline font-semibold">Reset
                    / Tampilkan Semua</a>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-5 gap-x-20">
            @forelse ($books as $book)
                <a href="{{ route('book.show', $book->slug) }}"
                    class="group  overflow-hidden transition duration-300 transform border border-gray-100 flex flex-col h-full ">

                    <div class="h-88 overflow-hidden bg-black/5 relative rounded-md flex justify-center p-4">
                        @if ($book->gambar)
                            <img src="{{ $book->cover_url }}"
                                class="h-full object-cover group-hover:scale-104 transition duration-500 rounded-r-2xl">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                No Cover
                            </div>
                        @endif

                        <span
                            class="absolute top-2 right-0 bg-background text-primary text-xs font-bold px-2 py-1 rounded rounded-r-none shadow group-hover:pr-3 transition-all duration-300">
                            Stok: {{ $book->stok }}
                        </span>
                    </div>

                    <div class="mt-4 flex flex-col grow group-hover:-translate-y-0.5 transition duration-200">
                        <h3 class="font-bold text-text text-lg leading-tight mb-1 line-clamp-2">{{ $book->judul }}</h3>
                        <p class="text-sm text-text/80 ">{{ $book->penulis }}</p>
                        <p class="text-md text-primary mb-4">{{ $book->category->name }}</p>
                    </div>
                </a>



            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-600">Buku tidak ditemukan</h3>
                    <p class="text-gray-400">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
            <div class="mt-8">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>



    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

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


    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to get dominant color from image
            function getDominantColor(imgElement, callback) {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Set canvas size
                canvas.width = imgElement.naturalWidth || imgElement.width;
                canvas.height = imgElement.naturalHeight || imgElement.height;

                // Draw image to canvas
                ctx.drawImage(imgElement, 0, 0, canvas.width, canvas.height);

                // Get image data
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;

                // Color counting object
                const colorCount = {};
                let maxCount = 0;
                let dominantColor = {
                    r: 51,
                    g: 65,
                    b: 85
                }; // default slate color

                // Sample pixels (every 10th pixel for performance)
                for (let i = 0; i < data.length; i += 40) {
                    const r = data[i];
                    const g = data[i + 1];
                    const b = data[i + 2];
                    const a = data[i + 3];

                    // Skip transparent pixels
                    if (a < 125) continue;

                    // Round colors to reduce variation
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

            // Function to darken color
            function darkenColor(color, percent) {
                return {
                    r: Math.round(color.r * (1 - percent)),
                    g: Math.round(color.g * (1 - percent)),
                    b: Math.round(color.b * (1 - percent))
                };
            }

            // Function to create gradient background
            function applyGradientBackground(card, color) {
                const darkerColor = darkenColor(color, 0.3);
                const darkestColor = darkenColor(color, 0.5);

                const gradient = `linear-gradient(135deg,
            rgba(${color.r}, ${color.g}, ${color.b}, 0.8) 0%,
            rgba(${darkerColor.r}, ${darkerColor.g}, ${darkerColor.b}, 0.9) 50%,
            rgba(${darkestColor.r}, ${darkestColor.g}, ${darkestColor.b}, 1) 100%)`;

                card.style.background = gradient;
            }

            // Process all book cards
            const bookCards = document.querySelectorAll('.book-card');

            bookCards.forEach(card => {
                const img = card.querySelector('.book-cover');

                if (img) {
                    // If image is already loaded
                    if (img.complete) {
                        getDominantColor(img, (color) => {
                            applyGradientBackground(card, color);
                        });
                    } else {
                        // Wait for image to load
                        img.addEventListener('load', function() {
                            getDominantColor(img, (color) => {
                                applyGradientBackground(card, color);
                            });
                        });

                        // Handle image load error
                        img.addEventListener('error', function() {
                            console.log('Failed to load image, using default gradient');
                        });
                    }
                }
            });
        });
    </script>
@endsection
