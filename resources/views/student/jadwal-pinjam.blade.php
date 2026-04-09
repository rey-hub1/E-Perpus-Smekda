@extends('layouts.app')

@section('title', 'Jadwalkan Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- Back Button -->
    <a href="{{ route('book.show', $book->slug) }}"
        class="inline-flex items-center gap-2 mb-8 text-sm font-medium text-text/50 hover:text-primary transition-colors group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Detail Buku
    </a>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-heading text-text">Jadwalkan Peminjaman</h1>
        <p class="text-sm text-text/50 mt-1">Pilih tanggal kamu akan mengambil buku di perpustakaan.</p>
    </div>

    <!-- Book Info Card -->
    <div class="bg-background border border-text/10 rounded-2xl p-5 mb-6 flex items-center gap-5">
        <div class="shrink-0 w-16 h-22">
            @if ($book->gambar)
                <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}"
                    class="w-16 h-22 object-cover rounded-lg shadow-md">
            @else
                <div class="w-16 h-22 bg-text/5 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-text/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
            @endif
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-bold uppercase tracking-widest text-text/30 mb-1">{{ $book->category->name ?? 'Buku' }}</p>
            <h2 class="font-bold text-text text-base leading-snug line-clamp-2">{{ $book->judul }}</h2>
            <p class="text-sm text-text/50 mt-1">{{ $book->penulis }}</p>
        </div>
    </div>

    <!-- Form Jadwal -->
    <form action="{{ route('pinjam.buku', $book->id) }}" method="POST" id="jadwalForm">
        @csrf

        <div class="bg-background border border-text/10 rounded-2xl overflow-hidden mb-5">

            <!-- Pilih Tanggal Ambil -->
            <div class="p-6 border-b border-text/10">
                <label class="block text-sm font-bold text-text mb-1">
                    Tanggal Pengambilan
                </label>
                <p class="text-xs text-text/40 mb-4">Pilih tanggal kamu akan datang ke perpustakaan untuk mengambil buku ini.</p>

                <input
                    type="date"
                    name="tanggal_ambil"
                    id="tanggal_ambil"
                    min="{{ \Carbon\Carbon::today()->toDateString() }}"
                    max="{{ \Carbon\Carbon::today()->addDays(30)->toDateString() }}"
                    value="{{ old('tanggal_ambil', \Carbon\Carbon::today()->toDateString()) }}"
                    class="w-full border border-text/10 rounded-xl px-4 py-3 text-sm font-medium text-text bg-background focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    required
                >

                @error('tanggal_ambil')
                    <p class="mt-2 text-xs text-primary font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Periode Peminjaman -->
            <div class="p-6 bg-background">
                <h3 class="text-xs font-bold text-text/40 uppercase tracking-widest mb-4">Ringkasan Peminjaman</h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5 text-sm text-text/60">
                            <svg class="w-4 h-4 shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                            </svg>
                            Tanggal Ambil
                        </div>
                        <span class="text-sm font-bold text-text" id="displayAmbil">—</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5 text-sm text-text/60">
                            <svg class="w-4 h-4 shrink-0 text-text/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                            </svg>
                            Durasi Peminjaman
                        </div>
                        <span class="text-sm font-bold text-text">10 hari</span>
                    </div>

                    <div class="h-px bg-text/10"></div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5 text-sm text-text/60">
                            <svg class="w-4 h-4 shrink-0 text-primary/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                            Batas Pengembalian
                        </div>
                        <span class="text-sm font-bold text-primary" id="displayDue">—</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catatan -->
        <div class="bg-cta border border-text/10 rounded-xl px-5 py-4 mb-6 flex items-start gap-3">
            <svg class="w-5 h-5 shrink-0 text-text/40 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-text">Perhatian</p>
                <p class="text-xs text-text/70 mt-0.5 leading-relaxed">
                    Pastikan kamu datang ke perpustakaan sesuai tanggal yang dipilih untuk mengambil buku.
                    Keterlambatan pengembalian akan dikenakan denda <span class="font-semibold text-primary">Rp1.000 per hari</span>.
                </p>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-primary hover:bg-secondary text-background font-bold text-base py-4 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/20 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
            </svg>
            Konfirmasi Peminjaman
        </button>
    </form>

</div>

<script>
    const BULAN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    function formatTanggal(dateStr) {
        if (!dateStr) return '—';
        const d = new Date(dateStr + 'T00:00:00');
        return d.getDate() + ' ' + BULAN[d.getMonth()] + ' ' + d.getFullYear();
    }

    function addDays(dateStr, days) {
        const d = new Date(dateStr + 'T00:00:00');
        d.setDate(d.getDate() + days);
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return y + '-' + m + '-' + day;
    }

    function updateRingkasan() {
        const val = document.getElementById('tanggal_ambil').value;
        document.getElementById('displayAmbil').textContent = val ? formatTanggal(val) : '—';
        document.getElementById('displayDue').textContent   = val ? formatTanggal(addDays(val, 10)) : '—';
    }

    document.getElementById('tanggal_ambil').addEventListener('change', updateRingkasan);
    updateRingkasan();
</script>
@endsection
