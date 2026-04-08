@extends('layouts.admin')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')
@section('page-subtitle', 'Perbarui informasi buku')

@section('content')
<div class="max-w-2xl">

    <!-- Back -->
    <a href="{{ route('admin.books.index') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-700 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Koleksi
    </a>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-100 rounded-xl px-5 py-4 mb-5">
            <p class="text-sm font-semibold text-primary mb-2">Perbaiki kesalahan berikut:</p>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-600 flex items-start gap-2">
                        <span class="mt-0.5 shrink-0">&#8226;</span>{{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
            <div class="px-6 py-4 border-b border-gray-100">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Informasi Buku</p>
            </div>
            <div class="px-6 py-5 space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $book->judul) }}"
                        class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                    <select name="category_id"
                        class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $book->penulis) }}"
                            class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit', $book->penerbit) }}"
                            class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
                            class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $book->stok) }}"
                            class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sinopsis / Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all resize-none">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                </div>

            </div>
        </div>

        <!-- Cover Upload -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
            <div class="px-6 py-4 border-b border-gray-100">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cover Buku</p>
            </div>
            <div class="px-6 py-5">

                @if ($book->gambar)
                    <div class="flex items-start gap-5 mb-4" id="currentCoverContainer">
                        <img src="{{ $book->cover_url }}" class="w-16 h-22 object-cover rounded-lg border border-gray-200 shadow-sm">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-1">Cover saat ini</p>
                            <p class="text-xs text-gray-400">Upload file baru untuk mengganti cover.</p>
                        </div>
                    </div>
                @endif

                <input type="file" id="imageInput" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-200 file:text-sm file:font-medium file:bg-white file:text-gray-600 hover:file:bg-gray-50 transition-all cursor-pointer">
                <input type="hidden" name="cropped_image" id="croppedImageData">
                <p class="text-xs text-gray-400 mt-2">Maksimal 5MB. Format: JPG, PNG, JPEG. Biarkan kosong jika tidak ingin mengganti cover.</p>

                <div id="cropperContainer" class="hidden mt-4">
                    <p class="text-xs font-semibold text-gray-600 mb-2">Sesuaikan posisi cover baru:</p>
                    <div class="max-h-96 overflow-hidden rounded-lg bg-gray-100 border border-gray-200">
                        <img id="imagePreview" src="" alt="Preview" class="max-w-full block">
                    </div>
                    <div class="mt-3 flex items-center gap-3">
                        <button type="button" id="cropButton"
                            class="bg-gray-900 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            Potong Gambar
                        </button>
                        <span id="cropSuccess" class="hidden text-xs font-semibold text-green-600 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Gambar berhasil dipotong
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 justify-end">
            <a href="{{ route('admin.books.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                Batal
            </a>
            <button type="submit" id="submitBtn"
                class="bg-primary hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                Simpan Perubahan
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
            const currentCoverContainer = document.getElementById('currentCoverContainer');

            let cropper;

            imageInput.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        cropperContainer.classList.remove('hidden');
                        if (currentCoverContainer) currentCoverContainer.classList.add('opacity-30');
                        if (cropper) cropper.destroy();
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
                    reader.readAsDataURL(files[0]);
                }
            });

            cropButton.addEventListener('click', function() {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({ width: 640, height: 853 });
                    croppedImageData.value = canvas.toDataURL('image/jpeg', 0.9);
                    cropSuccess.classList.remove('hidden');
                    cropperContainer.classList.add('opacity-50');
                    cropper.disable();
                }
            });

            document.querySelector('form').addEventListener('submit', function(e) {
                if (imageInput.files.length > 0 && !croppedImageData.value) {
                    e.preventDefault();
                    if (cropper) {
                        const canvas = cropper.getCroppedCanvas({ width: 640, height: 853 });
                        croppedImageData.value = canvas.toDataURL('image/jpeg', 0.9);
                        this.submit();
                    }
                }
            });
        });
    </script>
@endpush
