@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background-color: var(--color-background);">
    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('admin.books.index') }}"
           class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-lg transition-all hover:scale-105"
           style="background-color: var(--color-secondary); color: var(--color-background);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid md:grid-cols-5 gap-8">
                <!-- Image Section -->
                <div class="md:col-span-2 p-8 book-card transition-all duration-500" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
                    <div class="relative group">
                        @if($book->gambar)
                            <img src="/images/{{ $book->gambar }}"
                                 alt="{{ $book->judul }}"
                                 class="book-cover w-full h-auto rounded-lg shadow-2xl object-cover aspect-[3/4] transition-transform group-hover:scale-105"
                                 crossorigin="anonymous">
                        @else
                            <div class="w-full aspect-[3/4] bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Favorite Badge -->
                        @if($book->favorite)
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full p-3 shadow-lg">
                                <svg class="w-6 h-6" style="color: var(--color-accent);" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-white/90 backdrop-blur-sm rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold" style="color: var(--color-secondary);">{{ $book->stok }}</div>
                            <div class="text-sm mt-1" style="color: var(--color-text);">Stok Tersedia</div>
                        </div>
                        <div class="bg-white/90 backdrop-blur-sm rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold" style="color: var(--color-accent);">{{ $book->read_count }}</div>
                            <div class="text-sm mt-1" style="color: var(--color-text);">Kali Dibaca</div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="md:col-span-3 p-8">
                    <!-- Title -->
                    <h1 class="text-4xl font-bold mb-2" style="color: var(--color-text);">
                        {{ $book->judul }}
                    </h1>

                    <!-- Metadata -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium"
                              style="background-color: var(--color-primary); color: var(--color-background);">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                            {{ $book->penulis }}
                        </span>

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium"
                              style="background-color: var(--color-accent); color: white;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            {{ $book->penerbit }}
                        </span>

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium"
                              style="background-color: var(--color-secondary); color: white;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $book->tahun_terbit }}
                        </span>
                    </div>

                    <!-- Divider -->
                    <div class="h-px my-6" style="background-color: var(--color-primary);"></div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4" style="color: var(--color-text);">
                            Deskripsi Buku
                        </h2>
                        <div class="prose max-w-none" style="color: var(--color-text);">
                            <p class="text-lg leading-relaxed opacity-80">
                                {{ $book->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->


                    <!-- Additional Info -->
                    <div class="mt-8 p-6 rounded-lg" style="background-color: var(--color-background);">
                        <h3 class="font-semibold mb-3" style="color: var(--color-text);">Informasi Tambahan</h3>
                        <div class="grid sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="opacity-60">Slug:</span>
                                <span class="font-medium ml-2">{{ $book->slug }}</span>
                            </div>
                            <div>
                                <span class="opacity-60">Status:</span>
                                <span class="font-medium ml-2">
                                    @if($book->stok > 0)
                                        <span class="px-3 py-1 rounded-full text-xs" style="background-color: var(--color-accent); color: white;">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs bg-red-600 text-white">
                                            Habis
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            r: 221,
            g: 161,
            b: 94
        }; // default to primary color

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

    // Process book card
    const bookCard = document.querySelector('.book-card');

    if (bookCard) {
        const img = bookCard.querySelector('.book-cover');

        if (img) {
            // If image is already loaded
            if (img.complete) {
                getDominantColor(img, (color) => {
                    applyGradientBackground(bookCard, color);
                });
            } else {
                // Wait for image to load
                img.addEventListener('load', function() {
                    getDominantColor(img, (color) => {
                        applyGradientBackground(bookCard, color);
                    });
                });

                // Handle image load error
                img.addEventListener('error', function() {
                    console.log('Failed to load image, using default gradient');
                });
            }
        }
    }
});
</script>
@endsection
