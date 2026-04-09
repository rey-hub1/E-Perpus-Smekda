@extends('layouts.admin')

@section('title', 'Kelola Icon')
@section('page-title', 'Kelola Icon')
@section('page-subtitle', 'Tambah icon kustom untuk kategori buku')

@section('content')
<div class="space-y-6 max-w-4xl">

    @if (session('success'))
        <div class="bg-background border border-text/10 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-accent flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-text font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-background border border-text/10 rounded-xl px-5 py-4 flex items-center gap-3 text-sm">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <span class="text-text font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Form Tambah Icon --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-text">Tambah Icon Baru</p>
                <p class="text-xs text-text/40 mt-0.5">Salin SVG dari Heroicons lalu tempelkan di sini</p>
            </div>
            <a href="https://heroicons.com" target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 text-xs font-semibold text-primary border border-primary/20 bg-primary/5 hover:bg-primary/10 px-3 py-2 rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Buka Heroicons
            </a>
        </div>

        <div class="px-6 py-5">
            <form action="{{ route('admin.icons.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Kiri: Form input --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-text/60 uppercase tracking-wider mb-1.5">Nama Icon</label>
                            <input type="text" name="label" id="label-input"
                                placeholder="Contoh: Matahari, Daun Maple..."
                                value="{{ old('label') }}"
                                class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                                required>
                            @error('label')
                                <p class="text-xs text-primary mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-text/60 uppercase tracking-wider mb-1.5">
                                Tempel SVG dari Heroicons
                            </label>
                            <textarea id="svg-input" rows="6"
                                placeholder="Tempel SVG di sini...&#10;&#10;Contoh:&#10;<svg xmlns=&quot;...&quot; ...>&#10;  <path stroke-linecap=&quot;round&quot; .../>&#10;</svg>"
                                class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-xs font-mono focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all resize-none text-text/70"
                                oninput="parseSvg(this.value)"></textarea>
                            <input type="hidden" name="path" id="path-input" value="{{ old('path') }}">
                            @error('path')
                                <p class="text-xs text-primary mt-1 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-text/30 mt-1.5">
                                Di Heroicons: klik icon &rarr; klik <strong>Copy SVG</strong> &rarr; tempel di sini
                            </p>
                        </div>
                    </div>

                    {{-- Kanan: Preview --}}
                    <div class="flex flex-col gap-4">
                        <div>
                            <p class="text-xs font-semibold text-text/60 uppercase tracking-wider mb-1.5">Preview</p>
                            <div class="border border-dashed border-gray-200 rounded-xl p-6 flex flex-col items-center justify-center gap-3 bg-gray-50 min-h-40">
                                <div id="preview-icon" class="w-12 h-12 text-primary">
                                    {{-- Icon preview akan muncul di sini --}}
                                    <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" class="w-full h-full text-text/15">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                </div>
                                <p id="preview-label" class="text-xs text-text/30 font-medium">Tempel SVG untuk preview</p>
                            </div>
                        </div>

                        <div id="path-display" class="hidden">
                            <p class="text-xs font-semibold text-text/60 uppercase tracking-wider mb-1.5">Path yang diekstrak</p>
                            <div class="bg-gray-50 border border-gray-100 rounded-lg px-3 py-2.5 text-[10px] font-mono text-text/50 overflow-auto max-h-24 break-all" id="path-display-text"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-5 pt-5 border-t border-gray-100">
                    <p id="status-msg" class="text-xs text-text/40"></p>
                    <button type="submit" id="submit-btn" disabled
                        class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors disabled:opacity-40 disabled:cursor-not-allowed hover:bg-secondary">
                        Simpan Icon
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Icon Custom --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-sm font-semibold text-text">Icon Kustom</p>
            <p class="text-xs text-text/40 mt-0.5">{{ $icons->count() }} icon ditambahkan</p>
        </div>

        @if ($icons->isEmpty())
            <div class="px-6 py-14 text-center">
                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-gray-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-text/15" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                    </svg>
                </div>
                <p class="text-sm text-text/40 font-medium">Belum ada icon kustom</p>
                <p class="text-xs text-text/30 mt-1">Tambahkan icon pertamamu dari Heroicons di atas</p>
            </div>
        @else
            <div class="p-5 grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
                @foreach ($icons as $icon)
                    <div class="group relative flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-50 hover:bg-primary/5 border border-transparent hover:border-primary/15 transition-all">
                        <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"
                            class="w-7 h-7 text-text/60 group-hover:text-primary transition-colors">
                            {!! $icon->path !!}
                        </svg>
                        <span class="text-[10px] text-text/40 text-center leading-tight line-clamp-2">{{ $icon->label }}</span>
                        <form action="{{ route('admin.icons.destroy', $icon->id) }}" method="POST"
                            onsubmit="return confirm('Hapus icon {{ $icon->label }}?')"
                            class="absolute -top-1.5 -right-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-5 h-5 bg-primary rounded-full flex items-center justify-center shadow-sm hover:bg-secondary transition-colors">
                                <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<script>
function parseSvg(svgText) {
    const text = svgText.trim();
    if (!text) {
        resetPreview();
        return;
    }

    // Ekstrak semua <path .../> dari SVG
    const pathMatches = text.match(/<path[^>]*\/>/g) || text.match(/<path[^>]*>[\s\S]*?<\/path>/g);

    if (!pathMatches || pathMatches.length === 0) {
        document.getElementById('status-msg').textContent = 'Tidak ada path ditemukan. Pastikan SVG valid.';
        document.getElementById('status-msg').className = 'text-xs text-primary';
        document.getElementById('submit-btn').disabled = true;
        document.getElementById('path-input').value = '';
        document.getElementById('path-display').classList.add('hidden');
        updatePreview('');
        return;
    }

    const combinedPath = pathMatches.join('');
    document.getElementById('path-input').value = combinedPath;
    document.getElementById('path-display-text').textContent = combinedPath;
    document.getElementById('path-display').classList.remove('hidden');
    document.getElementById('status-msg').textContent = pathMatches.length + ' path diekstrak';
    document.getElementById('status-msg').className = 'text-xs text-accent font-medium';
    document.getElementById('submit-btn').disabled = false;

    updatePreview(combinedPath);
}

function updatePreview(pathHtml) {
    const container = document.getElementById('preview-icon');
    const labelEl = document.getElementById('preview-label');
    const nameInput = document.getElementById('label-input');

    if (!pathHtml) {
        container.innerHTML = '<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" class="w-full h-full text-text/15"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>';
        labelEl.textContent = 'Tempel SVG untuk preview';
        labelEl.className = 'text-xs text-text/30 font-medium';
        return;
    }

    container.innerHTML = '<svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" class="w-full h-full text-primary">' + pathHtml + '</svg>';
    labelEl.textContent = nameInput.value || 'Icon baru';
    labelEl.className = 'text-xs text-text/50 font-medium';
}

function resetPreview() {
    document.getElementById('submit-btn').disabled = true;
    document.getElementById('path-input').value = '';
    document.getElementById('status-msg').textContent = '';
    document.getElementById('path-display').classList.add('hidden');
    updatePreview('');
}

// Update label di preview saat nama diketik
document.getElementById('label-input').addEventListener('input', function() {
    const labelEl = document.getElementById('preview-label');
    if (document.getElementById('path-input').value) {
        labelEl.textContent = this.value || 'Icon baru';
    }
});
</script>
@endsection
