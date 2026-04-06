@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-cta">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-primary">Tambah Buku Baru</h2>
            <p class="text-gray-500 text-sm">Masukkan data buku lengkap dengan sinopsisnya.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Waduh, ada yang kurang pas nih:</p>
                <ul class="list-disc list-inside text-sm mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-primary font-semibold mb-2">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    class="w-full border @error('judul') border-red-500 @else border-gray-300 @enderror p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition"
                    placeholder="Contoh: Laskar Pelangi">

                @error('judul')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-primary font-semibold mb-2">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
                </div>
                <div>
                    <label class="block text-primary font-semibold mb-2">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-primary font-semibold mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
                </div>
                <div>
                    <label class="block text-primary font-semibold mb-2">Stok Awal</label>
                    <input type="number" name="stok" value="{{ old('stok') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition">
                </div>
            </div>
            <div class="flex flex-col w-full">
                <label for="category_id" class="block text-primary font-semibold mb-2">Kategori</label>
                <select name="category_id" class="bg-gray-50 rounded-lg p-2 px-3">
                    <option value="">-- Pilih Kategori --</option>

                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach

                </select>
            </div>
            <div>
                <label class="block text-primary font-semibold mb-2">Sinopsis / Deskripsi</label>
                <textarea name="deskripsi" rows="5"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition"
                    placeholder="Ceritakan isi bukunya di sini...">{{ old('deskripsi') }}</textarea>
            </div>

            <div
                class="p-4 bg-gray-50 rounded-lg border @error('gambar') border-red-500 bg-red-50 @else border-dashed border-gray-300 @enderror">
                <label class="block text-primary font-semibold mb-2">Upload Cover Buku</label>
                <input type="file" id="imageInput" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent/20 file:text-primary hover:file:bg-accent/40">

                <!-- Hidden Input for Cropped Image -->
                <input type="hidden" name="cropped_image" id="croppedImageData">

                <p class="text-xs text-gray-400 mt-2">*Maksimal ukuran: 5MB. Format: JPG, PNG, JPEG.</p>

                <!-- Cropper Preview Area -->
                <div id="cropperContainer" class="hidden mt-4">
                    <p class="text-sm font-bold text-primary mb-2">Sesuaikan Posisi Cover (640x853):</p>
                    <div class="max-h-[500px] overflow-hidden rounded-lg shadow-inner bg-gray-200">
                        <img id="imagePreview" src="" alt="Preview" class="max-w-full block">
                    </div>
                    <div class="mt-3 flex gap-2">
                        <button type="button" id="cropButton"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                            Potong Gambar
                        </button>
                        <span id="cropSuccess" class="hidden text-green-600 text-sm font-bold items-center flex">
                            ✅ Berhasil dipotong!
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4" id="formActions">
                <a href="{{ route('admin.books.index') }}"
                    class="mr-4 px-6 py-3 text-gray-500 hover:text-gray-700 font-medium">Batal</a>
                <button type="submit" id="submitBtn"
                    class="bg-cta text-primary font-bold px-8 py-3 rounded-lg hover:bg-yellow-400 transition shadow-lg transform hover:-translate-y-1">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const cropperContainer = document.getElementById('cropperContainer');
            const cropButton = document.getElementById('cropButton');
            const cropSuccess = document.getElementById('cropSuccess');
            const croppedImageData = document.getElementById('croppedImageData');
            const submitBtn = document.getElementById('submitBtn');

            let cropper;

            imageInput.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        cropperContainer.classList.remove('hidden');

                        if (cropper) {
                            cropper.destroy();
                        }

                        // Inisialisasi Cropper.js
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 640 / 853,
                            viewMode: 1,
                            dragMode: 'move',
                            autoCropArea: 1,
                            restore: false,
                            guides: true,
                            center: true,
                            highlight: false,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                        });
                        
                        cropSuccess.classList.add('hidden');
                        croppedImageData.value = '';
                    };

                    reader.readAsDataURL(file);
                }
            });

            cropButton.addEventListener('click', function() {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 640,
                        height: 853,
                    });

                    // Set value hidden input ke base64
                    croppedImageData.value = canvas.toDataURL('image/jpeg', 0.9);
                    cropSuccess.classList.remove('hidden');
                    cropperContainer.classList.add('opacity-50');
                    
                    // Kita matikan cropper biar gak kegeser lagi gak sengaja
                    cropper.disable();
                }
            });

            // Pastikan gambar di-crop sebelum submit jika ada gambar dipilih
            document.querySelector('form').addEventListener('submit', function(e) {
                if (imageInput.files.length > 0 && !croppedImageData.value) {
                    e.preventDefault();
                    
                    // Otomatis crop jika admin lupa klik tombol "Potong Gambar"
                    if (cropper) {
                        const canvas = cropper.getCroppedCanvas({
                            width: 640,
                            height: 853,
                        });
                        croppedImageData.value = canvas.toDataURL('image/jpeg', 0.9);
                        this.submit();
                    } else {
                        alert('Silakan pilih gambar dan sesuaikan posisinya dulu ya!');
                    }
                }
            });
        });
    </script>
@endpush
