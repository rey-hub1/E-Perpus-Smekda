@extends('layouts.admin')

@section('title', 'Import Massal Buku')
@section('page-title', 'Import Massal Buku')
@section('page-subtitle', 'Tambahkan banyak buku sekaligus via JSON')

@section('content')
<div x-data="bulkImport()" x-init="init()">

    <!-- Back -->
    <a href="{{ route('admin.books.index') }}"
        class="inline-flex items-center gap-2 text-sm text-text/40 hover:text-text mb-6 transition-colors font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Koleksi
    </a>

    <!-- Step Indicator -->
    <div class="flex items-center gap-3 mb-8">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                :class="step >= 1 ? 'bg-primary text-white' : 'bg-text/10 text-text/40'">1</div>
            <span class="text-sm font-medium" :class="step >= 1 ? 'text-text' : 'text-text/40'">Input JSON</span>
        </div>
        <div class="flex-1 h-px bg-text/10 max-w-16"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                :class="step >= 2 ? 'bg-primary text-white' : 'bg-text/10 text-text/40'">2</div>
            <span class="text-sm font-medium" :class="step >= 2 ? 'text-text' : 'text-text/40'">Tambah Gambar</span>
        </div>
        <div class="flex-1 h-px bg-text/10 max-w-16"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                :class="step >= 3 ? 'bg-primary text-white' : 'bg-text/10 text-text/40'">3</div>
            <span class="text-sm font-medium" :class="step >= 3 ? 'text-text' : 'text-text/40'">Simpan</span>
        </div>
    </div>

    <!-- ======================== STEP 1: JSON INPUT ======================== -->
    <div x-show="step === 1" x-transition>

        <div class="grid grid-cols-5 gap-5">
            <!-- Main JSON area -->
            <div class="col-span-3 bg-background rounded-xl border border-text/10 overflow-hidden">
                <div class="px-6 py-4 border-b border-text/5 flex items-center justify-between">
                    <p class="text-xs font-semibold text-text/40 uppercase tracking-wider">Data JSON</p>
                    <button type="button" @click="loadExample()"
                        class="text-xs text-primary hover:text-secondary font-semibold transition-colors">
                        Muat Contoh
                    </button>
                </div>
                <div class="px-6 py-5">
                    <textarea
                        x-model="jsonText"
                        rows="20"
                        placeholder='[&#10;  {&#10;    "judul": "Laskar Pelangi",&#10;    "penulis": "Andrea Hirata",&#10;    ...&#10;  }&#10;]'
                        class="w-full border border-text/10 rounded-lg px-3.5 py-2.5 text-sm bg-background text-text focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all resize-none font-mono"
                        spellcheck="false"
                        @input="jsonError = ''"
                    ></textarea>

                    <template x-if="jsonError">
                        <div class="mt-3 bg-primary/5 border border-primary/10 rounded-lg px-4 py-3">
                            <p class="text-sm text-primary flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                                </svg>
                                <span x-text="jsonError"></span>
                            </p>
                        </div>
                    </template>

                    <div class="mt-4 flex items-center gap-3">
                        <button type="button" @click="parseJson()"
                            class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                            Proses JSON
                        </button>
                        <span class="text-xs text-text/40">Pastikan format JSON sudah benar</span>
                    </div>
                </div>
            </div>

            <!-- Format Guide -->
            <div class="col-span-2 space-y-4">
                <div class="bg-background rounded-xl border border-text/10 overflow-hidden">
                    <div class="px-5 py-4 border-b border-text/5">
                        <p class="text-xs font-semibold text-text/40 uppercase tracking-wider">Format JSON</p>
                    </div>
                    <div class="px-5 py-4">
                        <pre class="text-xs text-text/70 bg-text/[0.03] rounded-lg p-4 overflow-x-auto leading-relaxed"><code>[
  {
    <span class="text-primary">"judul"</span>: "Judul Buku",
    <span class="text-primary">"penulis"</span>: "Nama Penulis",
    <span class="text-primary">"penerbit"</span>: "Nama Penerbit",
    <span class="text-primary">"tahun_terbit"</span>: 2023,
    <span class="text-primary">"stok"</span>: 10,
    <span class="text-primary">"jumlah_halaman"</span>: 320,
    <span class="text-primary">"category_id"</span>: 1,
    <span class="text-primary">"deskripsi"</span>: "Opsional..."
  }
]</code></pre>
                    </div>
                </div>

                <div class="bg-background rounded-xl border border-text/10 overflow-hidden">
                    <div class="px-5 py-4 border-b border-text/5">
                        <p class="text-xs font-semibold text-text/40 uppercase tracking-wider">Kategori Tersedia</p>
                    </div>
                    <div class="px-5 py-4 space-y-1.5">
                        @foreach ($categories as $cat)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-text/70">{{ $cat->name }}</span>
                                <span class="font-mono text-xs bg-text/5 px-2 py-0.5 rounded text-text/50">id: {{ $cat->id }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================== STEP 2: IMAGE ASSIGNMENT ======================== -->
    <div x-show="step === 2" x-transition>

        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="font-semibold text-text" x-text="books.length + ' buku siap diimpor'"></p>
                <p class="text-sm text-text/40 mt-0.5">Drag gambar ke masing-masing buku, lalu crop sesuai kebutuhan</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" @click="step = 1"
                    class="px-4 py-2 text-sm font-medium text-text/50 hover:text-text border border-text/10 rounded-lg transition-colors">
                    Kembali Edit JSON
                </button>
                <button type="button" @click="submitAll()"
                    class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    Simpan Semua Buku
                </button>
            </div>
        </div>

        <!-- Book Cards Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <template x-for="(book, index) in books" :key="index">
                <div class="bg-background rounded-xl border border-text/10 overflow-hidden flex flex-col">

                    <!-- Drop Zone -->
                    <div
                        class="relative group cursor-pointer border-b border-text/10 transition-colors"
                        :class="dragOverIndex === index ? 'bg-primary/5 border-primary/20' : 'bg-text/[0.02]'"
                        style="aspect-ratio: 3/4;"
                        @click="openFilePicker(index)"
                        @dragover.prevent="dragOverIndex = index"
                        @dragleave.prevent="dragOverIndex = null"
                        @drop.prevent="onDrop($event, index)"
                    >
                        <!-- Cropped Preview -->
                        <img x-show="cropData[index]"
                            :src="cropData[index]"
                            class="absolute inset-0 w-full h-full object-cover"
                            alt="">

                        <!-- Placeholder -->
                        <div x-show="!cropData[index]"
                            class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-text/30 group-hover:text-primary/60 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                            </svg>
                            <p class="text-xs font-medium">Drag gambar</p>
                            <p class="text-[10px]">atau klik untuk pilih</p>
                        </div>

                        <!-- Edit overlay when image exists -->
                        <div x-show="cropData[index]"
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-2">
                                <button type="button"
                                    @click.stop="openFilePicker(index)"
                                    class="bg-white text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                    Ganti
                                </button>
                                <button type="button"
                                    @click.stop="reCrop(index)"
                                    class="bg-white text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    Crop
                                </button>
                            </div>
                        </div>

                        <!-- Drop indicator badge -->
                        <div x-show="dragOverIndex === index"
                            class="absolute inset-0 border-2 border-dashed border-primary/40 rounded-t-xl pointer-events-none"></div>
                    </div>

                    <!-- Book Info -->
                    <div class="px-4 py-3 flex-1">
                        <p class="font-semibold text-sm text-text leading-snug line-clamp-2" x-text="book.judul"></p>
                        <p class="text-xs text-text/50 mt-0.5" x-text="book.penulis"></p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-[10px] text-text/40" x-text="book.tahun_terbit"></span>
                            <span class="text-[10px] font-semibold text-primary/70 bg-primary/8 px-2 py-0.5 rounded-full"
                                x-text="'Stok: ' + book.stok"></span>
                        </div>
                        <div x-show="book.jumlah_halaman" class="text-[10px] text-text/40 mt-0.5">
                            <span x-text="book.jumlah_halaman + ' halaman'"></span>
                        </div>
                        <div x-show="cropData[index]" class="mt-2 flex items-center gap-1 text-accent">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-[10px] font-semibold text-accent">Gambar siap</span>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        <!-- Bottom Action -->
        <div class="mt-6 flex items-center justify-between py-4 border-t border-text/10">
            <div class="text-sm text-text/50">
                <span x-text="Object.keys(cropData).length"></span> dari
                <span x-text="books.length"></span> buku sudah ada gambar
                <span class="text-text/30">(gambar bersifat opsional)</span>
            </div>
            <button type="button" @click="submitAll()"
                class="bg-primary hover:bg-secondary text-white font-semibold px-8 py-3 rounded-lg text-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                Simpan Semua Buku
            </button>
        </div>
    </div>

    <!-- ======================== CROP MODAL ======================== -->
    <div x-show="showCropModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.7);"
        @click.self="closeCropModal()">

        <div class="bg-background rounded-2xl border border-text/10 w-full max-w-lg shadow-2xl"
            @click.stop>

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-text/10 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-text text-sm">Sesuaikan Gambar Cover</p>
                    <p class="text-xs text-text/40 mt-0.5" x-text="activeCropIndex !== null ? 'Buku: ' + (books[activeCropIndex]?.judul ?? '') : ''"></p>
                </div>
                <button type="button" @click="closeCropModal()"
                    class="w-7 h-7 rounded-lg hover:bg-text/5 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-text/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Cropper Area -->
            <div class="px-6 py-5">
                <div class="rounded-xl overflow-hidden bg-text/5 border border-text/10" style="max-height: 400px;">
                    <img id="bulkCropImage" src="" alt="" class="max-w-full block">
                </div>
                <p class="text-xs text-text/30 mt-3">Rasio otomatis 3:4. Geser dan zoom untuk menyesuaikan area crop.</p>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 pb-5 flex items-center gap-3 justify-end">
                <button type="button" @click="closeCropModal()"
                    class="px-4 py-2 text-sm font-medium text-text/50 hover:text-text transition-colors">
                    Batal
                </button>
                <button type="button" @click="doCrop()"
                    class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5"/>
                    </svg>
                    Potong & Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden form for final submission -->
    <form id="bulkSubmitForm" method="POST" action="{{ route('admin.books.bulk-store') }}" style="display:none;">
        @csrf
    </form>

    <!-- Hidden file input -->
    <input type="file" id="bulkFileInput" accept="image/*" style="display:none;">

</div>
@endsection

@push('scripts')
<script>
function bulkImport() {
    return {
        step: 1,
        jsonText: '',
        jsonError: '',
        books: [],
        cropData: {},
        originalImageData: {},
        activeCropIndex: null,
        dragOverIndex: null,
        showCropModal: false,
        cropperInstance: null,

        init() {
            document.getElementById('bulkFileInput').addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    this.readFileAndOpenCrop(file, this._pendingPickerIndex);
                }
                e.target.value = '';
            });
        },

        loadExample() {
            const categories = @json($categories->pluck('id')->first() ?? 1);
            const example = [
                {
                    judul: "Laskar Pelangi",
                    penulis: "Andrea Hirata",
                    penerbit: "Bentang Pustaka",
                    tahun_terbit: 2005,
                    stok: 5,
                    jumlah_halaman: 529,
                    category_id: categories,
                    deskripsi: "Novel tentang persahabatan dan semangat anak-anak Belitung."
                },
                {
                    judul: "Bumi Manusia",
                    penulis: "Pramoedya Ananta Toer",
                    penerbit: "Hasta Mitra",
                    tahun_terbit: 1980,
                    stok: 3,
                    jumlah_halaman: 352,
                    category_id: categories,
                    deskripsi: "Novel sejarah karya Pramoedya Ananta Toer."
                }
            ];
            this.jsonText = JSON.stringify(example, null, 2);
            this.jsonError = '';
        },

        parseJson() {
            if (!this.jsonText.trim()) {
                this.jsonError = 'JSON tidak boleh kosong.';
                return;
            }
            try {
                const parsed = JSON.parse(this.jsonText);
                if (!Array.isArray(parsed)) {
                    this.jsonError = 'JSON harus berupa array (diawali [ dan diakhiri ]).';
                    return;
                }
                if (parsed.length === 0) {
                    this.jsonError = 'Array JSON kosong, tambahkan minimal 1 buku.';
                    return;
                }
                // Validate required fields
                const required = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok'];
                for (let i = 0; i < parsed.length; i++) {
                    for (const field of required) {
                        if (!parsed[i][field]) {
                            this.jsonError = `Buku ke-${i + 1} tidak memiliki field "${field}".`;
                            return;
                        }
                    }
                }
                this.books = parsed;
                this.cropData = {};
                this.originalImageData = {};
                this.jsonError = '';
                this.step = 2;
            } catch (e) {
                this.jsonError = 'Format JSON tidak valid: ' + e.message;
            }
        },

        openFilePicker(index) {
            this._pendingPickerIndex = index;
            document.getElementById('bulkFileInput').click();
        },

        readFileAndOpenCrop(file, index) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.originalImageData[index] = e.target.result;
                this.openCropModal(index, e.target.result);
            };
            reader.readAsDataURL(file);
        },

        onDrop(event, index) {
            this.dragOverIndex = null;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.readFileAndOpenCrop(file, index);
            }
        },

        reCrop(index) {
            if (this.originalImageData[index]) {
                this.openCropModal(index, this.originalImageData[index]);
            } else if (this.cropData[index]) {
                this.openCropModal(index, this.cropData[index]);
            }
        },

        openCropModal(index, imageSrc) {
            this.activeCropIndex = index;
            this.showCropModal = true;

            this.$nextTick(() => {
                const img = document.getElementById('bulkCropImage');
                img.src = imageSrc;

                if (this.cropperInstance) {
                    this.cropperInstance.destroy();
                    this.cropperInstance = null;
                }

                img.onload = () => {
                    this.cropperInstance = new Cropper(img, {
                        aspectRatio: 801 / 1206,
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
                };
            });
        },

        doCrop() {
            if (this.cropperInstance && this.activeCropIndex !== null) {
                const canvas = this.cropperInstance.getCroppedCanvas({ width: 801, height: 1206 });
                const base64 = canvas.toDataURL('image/jpeg', 0.9);
                this.cropData = { ...this.cropData, [this.activeCropIndex]: base64 };
                this.closeCropModal();
            }
        },

        closeCropModal() {
            if (this.cropperInstance) {
                this.cropperInstance.destroy();
                this.cropperInstance = null;
            }
            this.showCropModal = false;
            this.activeCropIndex = null;
            const img = document.getElementById('bulkCropImage');
            img.src = '';
        },

        submitAll() {
            const form = document.getElementById('bulkSubmitForm');

            // Clear previous inputs
            const oldInputs = form.querySelectorAll('input:not([name="_token"])');
            oldInputs.forEach(el => el.remove());

            // Add book data
            this.books.forEach((book, index) => {
                const fields = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'jumlah_halaman', 'category_id', 'deskripsi'];
                fields.forEach(field => {
                    if (book[field] !== undefined && book[field] !== null) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `books[${index}][${field}]`;
                        input.value = book[field];
                        form.appendChild(input);
                    }
                });

                // Add cropped image if exists
                if (this.cropData[index]) {
                    const imgInput = document.createElement('input');
                    imgInput.type = 'hidden';
                    imgInput.name = `cropped_images[${index}]`;
                    imgInput.value = this.cropData[index];
                    form.appendChild(imgInput);
                }
            });

            form.submit();
        }
    };
}
</script>
@endpush
