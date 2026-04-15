<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpus SMKN 2 Purwakarta - Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    
    <nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-sm">
        <div class="cont py-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/global/logo.png') }}" alt="GoRead Logo" class="h-14 w-auto">
            </div>

            <div class="hidden md:flex items-center gap-5">
                <a href="#popular" class="text-text/80 text-[0.8rem] font-medium tracking-[0.08em] uppercase transition-colors duration-300 hover:text-primary">Eksplorasi</a>
                <span class="w-1 h-1 bg-text/30 rounded-full inline-block"></span>
                <a href="#about" class="text-text/80 text-[0.8rem] font-medium tracking-[0.08em] uppercase transition-colors duration-300 hover:text-primary">Tentang</a>
                <span class="w-1 h-1 bg-text/30 rounded-full inline-block"></span>
                <a href="#maps" class="text-text/80 text-[0.8rem] font-medium tracking-[0.08em] uppercase transition-colors duration-300 hover:text-primary">Lokasi</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-primary text-background px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-secondary">Dashboard Admin</a>
                    @else
                        <a href="{{ route('student.home') }}" class="bg-primary text-background px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-secondary">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-primary text-background px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="border-[1.5px] border-text text-text px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-text hover:text-background">Daftar</a>
                @endauth
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-text/70 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-background/95 backdrop-blur-md border-b border-text/10">
            <div class="cont py-4 flex flex-col gap-4">
                <a href="#popular" class="text-text/80 text-[0.8rem] font-medium tracking-[0.08em] uppercase transition-colors duration-300 hover:text-primary">Eksplorasi</a>
                <a href="#about" class="text-text/80 text-[0.8rem] font-medium tracking-[0.08em] uppercase transition-colors duration-300 hover:text-primary">Tentang</a>
                <a href="#maps" class="text-text/80 text-[0.8rem] font-medium tracking-[0.08em] uppercase transition-colors duration-300 hover:text-primary">Lokasi</a>
                <div class="flex gap-3 pt-2 border-t border-text/10">
                    @auth
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-primary text-background px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-secondary">Dashboard Admin</a>
                        @else
                            <a href="{{ route('student.home') }}" class="bg-primary text-background px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-secondary">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-primary text-background px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-secondary">Masuk</a>
                        <a href="{{ route('register') }}" class="border-[1.5px] border-text text-text px-6 py-2 rounded-full font-semibold text-[0.875rem] transition-all duration-300 hover:bg-text hover:text-background">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    
    <section class="bg-[#0a0a0f] min-h-screen flex flex-col justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.025)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.025)_1px,transparent_1px)] bg-[size:60px_60px]"></div>
        <div class="absolute w-[600px] h-[600px] bg-[radial-gradient(circle,color-mix(in_srgb,var(--color-primary)_18%,transparent)_0%,transparent_70%)] rounded-full -top-[100px] -right-[100px] pointer-events-none"></div>
        <div class="absolute w-[400px] h-[400px] bg-[radial-gradient(circle,rgba(59,130,246,0.08)_0%,transparent_70%)] rounded-full bottom-0 -left-[100px] pointer-events-none"></div>

        <div class="cont relative z-10 pt-28 pb-20">
            <div class="max-w-4xl mx-auto text-center">

                
                <div class="flex justify-center mb-8">
                    <span class="inline-flex items-center gap-2 bg-[color-mix(in_srgb,var(--color-primary)_12%,transparent)] border border-[color-mix(in_srgb,var(--color-primary)_25%,transparent)] text-[color-mix(in_srgb,var(--color-primary)_80%,white)] px-4 py-1.5 rounded-full text-[0.78rem] font-bold tracking-wider uppercase">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                        Perpustakaan Digital SMKN 2 Purwakarta
                    </span>
                </div>

                
                <h1 class="font-heading font-bold leading-[1.1] tracking-tight">
                    <span class="block text-white text-5xl sm:text-6xl md:text-7xl lg:text-[5rem]">
                        Baca Lebih Banyak.
                    </span>
                    <span class="block mt-2 text-5xl sm:text-6xl md:text-7xl lg:text-[5rem] bg-linear-to-br from-[color-mix(in_srgb,var(--color-primary)_80%,white)] via-primary to-secondary bg-clip-text text-transparent">
                        Tumbuh Lebih Jauh.
                    </span>
                </h1>

                
                <p class="mt-8 text-white/50 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed">
                    Akses ribuan koleksi buku, jurnal, dan materi pembelajaran kapan saja
                    langsung dari perangkatmu. Gratis untuk seluruh siswa SMKN 2 Purwakarta.
                </p>

                
                <div class="mt-10 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4 sm:px-0">
                    @auth
                        <a href="{{ route('student.home') }}" class="bg-primary text-background px-10 py-3.5 rounded-full font-bold text-[0.95rem] tracking-wide transition-colors duration-300 hover:bg-secondary text-center">
                            Mulai Membaca →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-primary text-background px-10 py-3.5 rounded-full font-bold text-[0.95rem] tracking-wide transition-colors duration-300 hover:bg-secondary text-center">
                            Daftar Gratis →
                        </a>
                        <a href="{{ route('login') }}" class="bg-white/5 border border-white/15 text-white/80 px-10 py-3.5 rounded-full font-semibold text-[0.95rem] transition-all duration-300 hover:bg-white/10 hover:text-white text-center">
                            Masuk
                        </a>
                    @endauth
                </div>

                
                <div class="mt-16 flex justify-center">
                    <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl flex items-center flex-wrap justify-center gap-0 px-2 py-5">
                        <div class="flex flex-col items-center px-3.5 sm:px-5 md:px-7">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['buku'] }}+</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Koleksi Buku</span>
                        </div>
                        <div class="w-px h-10 bg-white/12 hidden sm:block"></div>
                        <div class="flex flex-col items-center px-3.5 sm:px-5 md:px-7">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['siswa'] }}+</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Siswa Aktif</span>
                        </div>
                        <div class="w-px h-10 bg-white/12 hidden sm:block"></div>
                        <div class="flex flex-col items-center px-3.5 sm:px-5 md:px-7">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['transaksi'] }}+</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Total Peminjaman</span>
                        </div>
                        <div class="w-px h-10 bg-white/12 hidden sm:block"></div>
                        <div class="flex flex-col items-center px-3.5 sm:px-5 md:px-7">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['kategori'] }}</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Kategori</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    
    <section id="popular" class="py-24 bg-background border-t border-text/10">
        <div class="cont">
            <div class="text-center mb-14">
                <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Koleksi Pilihan</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-text font-heading">Buku Terpopuler</h2>
                <p class="text-text/50 text-lg mt-3 max-w-lg mx-auto">Paling banyak dipinjam oleh siswa SMKN 2 Purwakarta</p>
            </div>
            <div class="flex justify-center gap-5 sm:gap-8 md:gap-10 flex-wrap">
                @foreach ($popularBooks as $book)
                    <x-book-cover :book="$book" :large="true" />
                @endforeach
            </div>
        </div>
    </section>

    
    <section id="about" class="py-24 bg-text/2 border-t border-text/10">
        <div class="cont">
            <div class="grid md:grid-cols-2 gap-8 md:gap-16 items-center">
                <div>
                    <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Tentang Kami</p>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-text leading-tight">
                        Perpustakaan Digital<br>untuk Generasi Modern
                    </h2>
                    <p class="mt-6 text-text/60 text-lg leading-relaxed">
                        E-Perpus SMKN 2 Purwakarta hadir sebagai solusi digital untuk memudahkan siswa
                        dalam mengakses ribuan koleksi buku, jurnal, dan materi pembelajaran kapan saja
                        dan di mana saja.
                    </p>
                    <p class="mt-4 text-text/60 text-lg leading-relaxed">
                        Dengan sistem yang modern dan mudah digunakan, kami berkomitmen untuk meningkatkan
                        minat baca dan mendukung proses pembelajaran yang lebih efektif.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('register') }}" class="bg-primary text-background px-12 py-3.5 rounded-full font-semibold text-base transition-colors duration-300 hover:bg-secondary inline-block">
                            Bergabung Sekarang
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="bg-white rounded-[20px] p-8 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.05)] text-center">
                        <div class="w-[52px] h-[52px] bg-[color-mix(in_srgb,var(--color-primary)_10%,transparent)] rounded-[14px] flex items-center justify-center mx-auto mb-4 text-[1.4rem]">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['buku'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Koleksi Buku</div>
                    </div>
                    <div class="bg-white rounded-[20px] p-8 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.05)] text-center">
                        <div class="w-[52px] h-[52px] bg-[color-mix(in_srgb,var(--color-primary)_10%,transparent)] rounded-[14px] flex items-center justify-center mx-auto mb-4 text-[1.4rem]">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['siswa'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Siswa Terdaftar</div>
                    </div>
                    <div class="bg-white rounded-[20px] p-8 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.05)] text-center">
                        <div class="w-[52px] h-[52px] bg-[color-mix(in__srgb,var(--color-primary)_10%,transparent)] rounded-[14px] flex items-center justify-center mx-auto mb-4 text-[1.4rem]">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['transaksi'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Total Peminjaman</div>
                    </div>
                    <div class="bg-white rounded-[20px] p-8 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.05)] text-center">
                        <div class="w-[52px] h-[52px] bg-[color-mix(in_srgb,var(--color-primary)_10%,transparent)] rounded-[14px] flex items-center justify-center mx-auto mb-4 text-[1.4rem]">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['kategori'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Kategori Buku</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="maps" class="py-24 bg-background border-t border-text/10">
        <div class="cont">
            <div class="text-center mb-14">
                <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Lokasi</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-text mb-2">Temukan Kami</h2>
                <p class="text-text/50 text-lg">SMKN 2 Purwakarta, Jawa Barat</p>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-lg h-56 sm:h-80 md:h-96 lg:h-[504px] border border-text/10">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.77000106877!2d107.43932322577727!3d-6.550696643442323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690e5975014a5d%3A0x87f7a97e7f9f961!2sSMKN%202%20Purwakarta!5e0!3m2!1sid!2sid!4v1769698917066!5m2!1sid!2sid"
                    class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    
    <section class="py-24 bg-text/2 border-t border-text/10">
        <div class="cont">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Feedback</p>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-gray-900 mb-4">Kirim Pendapat Anda</h2>
                    <p class="text-gray-500 text-lg">Bantu kami menjadi lebih baik dengan masukan kamu</p>
                </div>
                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100">
                    <form class="space-y-6">
                        <div>
                            <input type="email" placeholder="Email kamu"
                                class="w-full px-6 py-4 rounded-full bg-gray-50 text-text placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 border border-gray-200 transition text-sm">
                        </div>
                        <div>
                            <textarea rows="5" placeholder="Pesan kamu..."
                                class="w-full px-6 py-4 rounded-2xl bg-gray-50 text-text placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 border border-gray-200 transition resize-none text-sm"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="bg-primary text-background px-12 py-3.5 rounded-full font-semibold text-base transition-colors duration-300 hover:bg-secondary">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

     <footer class="bg-[#080810] py-20 border-t border-white/5">
        <div class="cont">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
                
                <div class="md:col-span-4">
                    <img src="{{ asset('images/global/logo.png') }}" alt="GoRead Logo" class="h-12 w-auto brightness-0 invert opacity-80 mb-6">
                    <div class="w-10 h-[3px] bg-primary rounded-full mt-3"></div>
                    <p class="mt-8 text-white/50 text-sm leading-relaxed max-w-xs">
                        Pusat literasi digital SMKN 2 Purwakarta. Bangun masa depanmu melalui kebiasaan membaca hari ini.
                    </p>
                    
                    <div class="flex gap-4 mt-8">
                        <a href="#" class="w-[38px] h-[38px] bg-white/5 border border-white/10 rounded-[10px] flex items-center justify-center text-[0.9rem] transition-all duration-250 hover:bg-primary/15 hover:border-primary/30 group">
                            <svg class="w-4 h-4 text-white/60 group-hover:text-primary transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-[38px] h-[38px] bg-white/5 border border-white/10 rounded-[10px] flex items-center justify-center text-[0.9rem] transition-all duration-250 hover:bg-primary/15 hover:border-primary/30 group">
                            <svg class="w-4 h-4 text-white/60 group-hover:text-primary transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                        </a>
                        <a href="#" class="w-[38px] h-[38px] bg-white/5 border border-white/10 rounded-[10px] flex items-center justify-center text-[0.9rem] transition-all duration-250 hover:bg-primary/15 hover:border-primary/30 group">
                            <svg class="w-4 h-4 text-white/60 group-hover:text-primary transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    </div>
                </div>

                
                <div class="md:col-span-2 md:col-start-6">
                    <h4 class="text-white/80 font-bold text-sm uppercase tracking-wider mb-8">Navigasi</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-white/45 text-[0.9rem] flex items-center gap-2.5 transition-colors duration-250 hover:text-primary group"><span class="w-1.5 h-1.5 bg-primary/40 rounded-full group-hover:bg-primary transition-colors"></span>Beranda</a></li>
                        <li><a href="#popular" class="text-white/45 text-[0.9rem] flex items-center gap-2.5 transition-colors duration-250 hover:text-primary group"><span class="w-1.5 h-1.5 bg-primary/40 rounded-full group-hover:bg-primary transition-colors"></span>Katalog Buku</a></li>
                        <li><a href="#about" class="text-white/45 text-[0.9rem] flex items-center gap-2.5 transition-colors duration-250 hover:text-primary group"><span class="w-1.5 h-1.5 bg-primary/40 rounded-full group-hover:bg-primary transition-colors"></span>Tentang Kami</a></li>
                        <li><a href="#maps" class="text-white/45 text-[0.9rem] flex items-center gap-2.5 transition-colors duration-250 hover:text-primary group"><span class="w-1.5 h-1.5 bg-primary/40 rounded-full group-hover:bg-primary transition-colors"></span>Lokasi</a></li>
                    </ul>
                </div>

                
                <div class="md:col-span-2">
                    <h4 class="text-white/80 font-bold text-sm uppercase tracking-wider mb-8">Akun</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('login') }}" class="text-white/45 text-[0.9rem] flex items-center gap-2.5 transition-colors duration-250 hover:text-primary group"><span class="w-1.5 h-1.5 bg-primary/40 rounded-full group-hover:bg-primary transition-colors"></span>Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="text-white/45 text-[0.9rem] flex items-center gap-2.5 transition-colors duration-250 hover:text-primary group"><span class="w-1.5 h-1.5 bg-primary/40 rounded-full group-hover:bg-primary transition-colors"></span>Daftar</a></li>
                    </ul>
                </div>

                
                <div class="md:col-span-3 md:col-start-10">
                    <h4 class="text-white/80 font-bold text-sm uppercase tracking-wider mb-8">Kontak</h4>
                    <ul class="space-y-5">
                        <li class="flex items-start gap-4 text-white/45 text-[0.9rem]">
                            <span class="w-[34px] h-[34px] flex-shrink-0 bg-primary/10 border border-primary/20 rounded-[9px] flex items-center justify-center text-[0.9rem]">
                                <svg class="w-4 h-4 text-primary/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                            </span>
                            <span>perpus@smkn2pwk.sch.id</span>
                        </li>
                        <li class="flex items-start gap-4 text-white/45 text-[0.9rem]">
                            <span class="w-[34px] h-[34px] flex-shrink-0 bg-primary/10 border border-primary/20 rounded-[9px] flex items-center justify-center text-[0.9rem]">
                                <svg class="w-4 h-4 text-primary/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            </span>
                            <span>(0264) 123456</span>
                        </li>
                        <li class="flex items-start gap-4 text-white/45 text-[0.9rem]">
                            <span class="w-[34px] h-[34px] flex-shrink-0 bg-primary/10 border border-primary/20 rounded-[9px] flex items-center justify-center text-[0.9rem]">
                                <svg class="w-4 h-4 text-primary/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            </span>
                            <span>Jl. Industri No.1,<br>Purwakarta, Jawa Barat 41114</span>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-white/20 text-sm">
                    &copy; {{ date('Y') }} E-Perpus SMKN 2 Purwakarta. All rights reserved.
                </p>
                <p class="text-white/20 text-xs">
                    Dibuat dengan penuh semangat untuk kemajuan pendidikan
                </p>
            </div>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn?.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    </script>

</body>
</html>
