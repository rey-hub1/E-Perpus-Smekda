@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui nama dan icon kategori')

@section('content')
<div class="max-w-xl">

    <a href="{{ route('admin.categories.index') }}"
        class="inline-flex items-center gap-2 text-sm text-text/40 hover:text-text mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Kategori
    </a>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold text-text/40 uppercase tracking-wider">Informasi Kategori</p>
        </div>
        <div class="px-6 py-5">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-text mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" id="name"
                        placeholder="Masukkan nama kategori"
                        class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icon Picker --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-text mb-3">Icon Kategori</label>
                    <input type="hidden" name="icon" id="icon-input" value="{{ old('icon', $category->icon ?? 'book-open') }}">

                    @php
                    $iconList = [
                        'book-open' => 'Buku', 'academic-cap' => 'Pendidikan', 'beaker' => 'Sains',
                        'calculator' => 'Matematika', 'globe' => 'Geografi', 'musical-note' => 'Musik',
                        'film' => 'Film', 'light-bulb' => 'Teknologi', 'heart' => 'Roman',
                        'trophy' => 'Olahraga', 'paint-brush' => 'Seni', 'star' => 'Unggulan',
                        'map' => 'Peta', 'rocket-launch' => 'Fiksi Ilmiah', 'building-library' => 'Sejarah',
                        'cpu-chip' => 'Komputer', 'language' => 'Bahasa', 'newspaper' => 'Berita',
                        'sparkles' => 'Spesial', 'magnifying-glass' => 'Riset',
                        'puzzle-piece' => 'Teka-teki', 'leaf' => 'Alam',
                    ];
                    // Merge icon kustom dari DB
                    $iconList = array_merge($iconList, $customIcons->toArray());
                    $selectedIcon = old('icon', $category->icon ?? 'book-open');
                    @endphp

                    <div class="grid grid-cols-6 gap-2">
                        @foreach ($iconList as $key => $label)
                            <button type="button"
                                onclick="selectIcon('{{ $key }}')"
                                id="icon-btn-{{ $key }}"
                                title="{{ $label }}"
                                class="icon-btn flex flex-col items-center gap-1.5 p-2.5 rounded-xl border-2 transition-all duration-150
                                    {{ $selectedIcon === $key ? 'border-primary bg-primary/5' : 'border-transparent bg-gray-50 hover:bg-gray-100' }}">
                                <x-category-icon :name="$key" class="w-5 h-5 text-text/60" />
                                <span class="text-[9px] text-text/40 leading-none text-center">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-3 justify-end pt-2 border-t border-gray-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-text/50 hover:text-text transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function selectIcon(key) {
    document.getElementById('icon-input').value = key;
    document.querySelectorAll('.icon-btn').forEach(btn => {
        btn.classList.remove('border-primary', 'bg-primary/5');
        btn.classList.add('border-transparent', 'bg-gray-50');
    });
    const selected = document.getElementById('icon-btn-' + key);
    if (selected) {
        selected.classList.add('border-primary', 'bg-primary/5');
        selected.classList.remove('border-transparent', 'bg-gray-50');
    }
}
</script>
@endsection
