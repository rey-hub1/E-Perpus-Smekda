<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpus SMKN 2 Purwakarta - Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── NAV ── */
        .nav-link-landing {
            color: var(--color-text);
            opacity: 0.8;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }
        .nav-link-landing:hover { color: var(--color-primary); opacity: 1; }

        .nav-dot {
            width: 4px; height: 4px;
            background-color: var(--color-text);
            opacity: 0.3;
            border-radius: 50%; display: inline-block;
        }

        .btn-masuk {
            background-color: var(--color-primary); color: var(--color-background);
            padding: 8px 24px; border-radius: 9999px;
            font-weight: 600; font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-masuk:hover { background-color: var(--color-secondary); }

        .btn-daftar {
            border: 1.5px solid var(--color-text); color: var(--color-text);
            padding: 8px 24px; border-radius: 9999px;
            font-weight: 600; font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-daftar:hover { background-color: var(--color-text); color: var(--color-background); }

        /* ── HERO ── */
        .hero-bg {
            background: #0a0a0f;
            position: relative;
            overflow: hidden;
        }
        .hero-glow-red {
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, color-mix(in srgb, var(--color-primary) 18%, transparent) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px; right: -100px;
            pointer-events: none;
        }
        .hero-glow-blue {
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: 0; left: -100px;
            pointer-events: none;
        }
        .hero-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .badge-hero {
            display: inline-flex; align-items: center; gap: 8px;
            background: color-mix(in srgb, var(--color-primary) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--color-primary) 25%, transparent);
            color: color-mix(in srgb, var(--color-primary) 80%, white);
            padding: 6px 16px; border-radius: 9999px;
            font-size: 0.78rem; font-weight: 600; letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .badge-dot {
            width: 6px; height: 6px;
            background: var(--color-primary); border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }
        .btn-hero-primary {
            background: var(--color-primary); color: var(--color-background);
            padding: 14px 40px; border-radius: 9999px;
            font-weight: 700; font-size: 0.95rem;
            letter-spacing: 0.02em;
            transition: all 0.3s ease;
            box-shadow: 0 0 30px color-mix(in srgb, var(--color-primary) 35%, transparent);
        }
        .btn-hero-primary:hover {
            background: var(--color-secondary); transform: translateY(-2px);
            box-shadow: 0 0 40px color-mix(in srgb, var(--color-primary) 50%, transparent);
        }
        .btn-hero-ghost {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.8);
            padding: 14px 40px; border-radius: 9999px;
            font-weight: 600; font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .btn-hero-ghost:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .hero-stat-item {
            display: flex; flex-direction: column; align-items: center;
            padding: 0 14px;
        }
        @media (min-width: 640px) {
            .hero-stat-item { padding: 0 22px; }
        }
        @media (min-width: 768px) {
            .hero-stat-item { padding: 0 28px; }
        }
        .hero-stat-divider {
            width: 1px; height: 40px;
            background: rgba(255,255,255,0.12);
        }
        .hero-floating-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border-radius: 16px;
        }

        /* ── FADE ANIMATIONS ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-delay-1 { animation-delay: 0.15s; }
        .animate-delay-2 { animation-delay: 0.3s; }
        .animate-delay-3 { animation-delay: 0.5s; }
        .animate-delay-4 { animation-delay: 0.65s; }

        .section-fade {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .section-fade.visible { opacity: 1; transform: translateY(0); }

        /* ── ABOUT STATS CARD ── */
        .stat-card {
            background: white; border-radius: 20px;
            padding: 2rem; border: 1px solid #f3f4f6;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 52px; height: 52px;
            background: color-mix(in srgb, var(--color-primary) 10%, transparent); border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.4rem;
        }

        /* ── FOOTER ── */
        .footer-bg { background: #080810; }
        .footer-brand-line {
            width: 40px; height: 3px;
            background: var(--color-primary); border-radius: 9999px;
            margin-top: 12px;
        }
        .footer-link {
            color: color-mix(in srgb, var(--color-background) 45%, transparent);
            font-size: 0.9rem;
            transition: color 0.25s;
            display: flex; align-items: center; gap: 6px;
        }
        .footer-link:hover { color: color-mix(in srgb, var(--color-primary) 80%, white); }
        .footer-link::before {
            content: '';
            width: 5px; height: 5px;
            background: rgba(220,38,38,0.4);
            border-radius: 50%;
            display: inline-block;
            transition: background 0.25s;
        }
        .footer-link:hover::before { background: #DC2626; }
        .footer-contact-item {
            display: flex; align-items: flex-start; gap: 12px;
            color: rgba(255,255,255,0.45); font-size: 0.9rem;
        }
        .footer-contact-icon {
            width: 34px; height: 34px; flex-shrink: 0;
            background: rgba(220,38,38,0.1);
            border: 1px solid rgba(220,38,38,0.2);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
        }
        .footer-social {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            transition: all 0.25s;
        }
        .footer-social:hover {
            background: rgba(220,38,38,0.15);
            border-color: rgba(220,38,38,0.3);
        }
        .footer-divider { border-color: rgba(255,255,255,0.07); }

        /* ── MOBILE MENU ── */
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .mobile-menu.open { max-height: 400px; }

        /* ── BTN PRIMARY (sections) ── */
        .btn-primary-landing {
            background-color: var(--color-primary); color: var(--color-background);
            padding: 14px 48px; border-radius: 9999px;
            font-weight: 600; font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--color-primary) 30%, transparent);
        }
        .btn-primary-landing:hover {
            background-color: var(--color-secondary); transform: translateY(-2px);
            box-shadow: 0 6px 20px color-mix(in srgb, var(--color-primary) 40%, transparent);
        }
    </style>
</head>

<body class="font-sans antialiased">

    <!-- ═══════════════════════════ NAVIGATION ═══════════════════════════ -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-sm">
        <div class="cont py-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/global/logo.png') }}" alt="GoRead Logo" class="h-14 w-auto">
            </div>

            <div class="hidden md:flex items-center gap-5">
                <a href="#popular" class="nav-link-landing">Eksplorasi</a>
                <span class="nav-dot"></span>
                <a href="#about" class="nav-link-landing">Tentang</a>
                <span class="nav-dot"></span>
                <a href="#maps" class="nav-link-landing">Lokasi</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-masuk">Dashboard Admin</a>
                    @else
                        <a href="{{ route('student.home') }}" class="btn-masuk">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                @endauth
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-text/70 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="mobile-menu md:hidden bg-background/95 backdrop-blur-md border-b border-text/10">
            <div class="cont py-4 flex flex-col gap-4">
                <a href="#popular" class="nav-link-landing">Eksplorasi</a>
                <a href="#about" class="nav-link-landing">Tentang</a>
                <a href="#maps" class="nav-link-landing">Lokasi</a>
                <div class="flex gap-3 pt-2 border-t border-text/10">
                    @auth
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-masuk">Dashboard Admin</a>
                        @else
                            <a href="{{ route('student.home') }}" class="btn-masuk">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ═══════════════════════════ HERO ═══════════════════════════ -->
    <section class="hero-bg min-h-screen flex flex-col justify-center relative">
        <div class="hero-grid"></div>
        <div class="hero-glow-red"></div>
        <div class="hero-glow-blue"></div>

        <div class="cont relative z-10 pt-28 pb-20">
            <div class="max-w-4xl mx-auto text-center">

                <!-- Badge -->
                <div class="opacity-0 animate-fade-in-up flex justify-center mb-8">
                    <span class="badge-hero">
                        <span class="badge-dot"></span>
                        Perpustakaan Digital SMKN 2 Purwakarta
                    </span>
                </div>

                <!-- Headline -->
                <h1 class="opacity-0 animate-fade-in-up animate-delay-1 font-heading font-bold leading-[1.1] tracking-tight">
                    <span class="block text-white text-5xl sm:text-6xl md:text-7xl lg:text-[5rem]">
                        Baca Lebih Banyak.
                    </span>
                    <span class="block mt-2 text-5xl sm:text-6xl md:text-7xl lg:text-[5rem]"
                          style="background: linear-gradient(135deg,color-mix(in srgb, var(--color-primary) 80%, white) 0%,var(--color-primary) 50%,var(--color-secondary) 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                        Tumbuh Lebih Jauh.
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="opacity-0 animate-fade-in-up animate-delay-2 mt-8 text-white/50 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed">
                    Akses ribuan koleksi buku, jurnal, dan materi pembelajaran kapan saja
                    langsung dari perangkatmu. Gratis untuk seluruh siswa SMKN 2 Purwakarta.
                </p>

                <!-- CTA Buttons -->
                <div class="opacity-0 animate-fade-in-up animate-delay-3 mt-10 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4 sm:px-0">
                    @auth
                        <a href="{{ route('student.home') }}" class="btn-hero-primary text-center">
                            Mulai Membaca →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-hero-primary text-center">
                            Daftar Gratis →
                        </a>
                        <a href="{{ route('login') }}" class="btn-hero-ghost text-center">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Hero Stats -->
                <div class="opacity-0 animate-fade-in-up animate-delay-4 mt-16 flex justify-center">
                    <div class="hero-floating-card flex items-center flex-wrap justify-center gap-0 px-2 py-5">
                        <div class="hero-stat-item">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['buku'] }}+</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Koleksi Buku</span>
                        </div>
                        <div class="hero-stat-divider hidden sm:block"></div>
                        <div class="hero-stat-item">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['siswa'] }}+</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Siswa Aktif</span>
                        </div>
                        <div class="hero-stat-divider hidden sm:block"></div>
                        <div class="hero-stat-item">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['transaksi'] }}+</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Total Peminjaman</span>
                        </div>
                        <div class="hero-stat-divider hidden sm:block"></div>
                        <div class="hero-stat-item">
                            <span class="text-2xl font-bold font-heading text-white">{{ $stats['kategori'] }}</span>
                            <span class="text-xs text-white/40 mt-0.5 uppercase tracking-wider">Kategori</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-30">
            <span class="text-white text-xs tracking-widest uppercase">Scroll</span>
            <div class="w-px h-10 bg-white/40 relative overflow-hidden">
                <div class="w-full h-1/2 bg-white/70 absolute top-0 animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════ POPULAR BOOKS ═══════════════════════════ -->
    <section id="popular" class="py-24 bg-background border-t border-text/10 section-fade">
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

    <!-- ═══════════════════════════ ABOUT ═══════════════════════════ -->
    <section id="about" class="py-24 bg-text/2 border-t border-text/10 section-fade">
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
                        <a href="{{ route('register') }}" class="btn-primary-landing inline-block">
                            Bergabung Sekarang
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['buku'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Koleksi Buku</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['siswa'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Siswa Terdaftar</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['transaksi'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Total Peminjaman</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/></svg>
                        </div>
                        <div class="text-3xl font-bold text-primary font-heading">{{ $stats['kategori'] }}</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Kategori Buku</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════ MAPS ═══════════════════════════ -->
    <section id="maps" class="py-24 bg-background border-t border-text/10 section-fade">
        <div class="cont">
            <div class="text-center mb-14">
                <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Lokasi</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-text mb-2">Temukan Kami</h2>
                <p class="text-text/50 text-lg">SMKN 2 Purwakarta, Jawa Barat</p>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-lg h-56 sm:h-80 md:h-96 lg:h-[504px] border border-text/10">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.77000106877!2d107.43932322577727!3d-6.550696643442323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690e5975014a5d%3A0x87f7a97e7f9f961!2sSMKN%202%20Purwakarta!5e0!3m2!1sid!2sid!4v1769698917066!5m2!1sid!2sid"
                    class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════ FEEDBACK ═══════════════════════════ -->
    <section class="py-24 bg-text/2 border-t border-text/10 section-fade">
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
                            <button type="submit" class="btn-primary-landing">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════ FOOTER ═══════════════════════════ -->
    <footer class="footer-bg">
        <div class="cont pt-16 pb-8">

            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-8 md:gap-12 mb-12">

                <!-- Brand Column -->
                <div class="sm:col-span-2 md:col-span-4">
                    <img src="{{ asset('images/global/logo.png') }}" alt="GoRead Logo" class="h-16 w-auto mb-4 brightness-0 invert opacity-90">
                    <div class="footer-brand-line"></div>
                    <p class="mt-5 text-text/40 text-sm leading-relaxed max-w-xs">
                        Platform perpustakaan digital SMKN 2 Purwakarta. Mendukung kegiatan belajar
                        mengajar melalui akses literasi yang mudah dan modern.
                    </p>
                    <!-- Social -->
                    <div class="flex gap-3 mt-7">
                        <a href="#" class="footer-social" title="Instagram">
                            <svg class="w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="footer-social" title="YouTube">
                            <svg class="w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                            </svg>
                        </a>
                        <a href="#" class="footer-social" title="Facebook">
                            <svg class="w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="md:col-span-2 md:col-start-6">
                    <h4 class="text-text/80 font-semibold text-sm uppercase tracking-wider mb-5">Navigasi</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="footer-link">Beranda</a></li>
                        <li><a href="#popular" class="footer-link">Katalog Buku</a></li>
                        <li><a href="#about" class="footer-link">Tentang Kami</a></li>
                        <li><a href="#maps" class="footer-link">Lokasi</a></li>
                    </ul>
                </div>

                <!-- Akun Links -->
                <div class="md:col-span-2">
                    <h4 class="text-text/80 font-semibold text-sm uppercase tracking-wider mb-5">Akun</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('login') }}" class="footer-link">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="footer-link">Daftar</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="md:col-span-3 md:col-start-10">
                    <h4 class="text-text/80 font-semibold text-sm uppercase tracking-wider mb-5">Kontak</h4>
                    <ul class="space-y-4">
                        <li class="footer-contact-item">
                            <span class="footer-contact-icon">
                                <svg class="w-4 h-4 text-primary/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                            </span>
                            <span class="text-text/50">perpus@smkn2pwk.sch.id</span>
                        </li>
                        <li class="footer-contact-item">
                            <span class="footer-contact-icon">
                                <svg class="w-4 h-4 text-primary/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            </span>
                            <span class="text-text/50">(0264) 123456</span>
                        </li>
                        <li class="footer-contact-item">
                            <span class="footer-contact-icon">
                                <svg class="w-4 h-4 text-primary/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            </span>
                            <span class="text-text/50">Jl. Industri No.1,<br>Purwakarta, Jawa Barat 41114</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-text/5 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-text/20 text-sm">
                    &copy; {{ date('Y') }} E-Perpus SMKN 2 Purwakarta. All rights reserved.
                </p>
                <p class="text-text/20 text-xs">
                    Dibuat dengan penuh semangat untuk kemajuan pendidikan
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn?.addEventListener('click', () => mobileMenu.classList.toggle('open'));

        // Scroll fade-in
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.section-fade').forEach(el => observer.observe(el));
    </script>

</body>
</html>
