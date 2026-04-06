<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpus SMKN 2 Purwakarta - Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }

        .hero-gradient {
            background: linear-gradient(180deg, #d2d8de 0%, #c8ced6 30%, #e0d8cc 70%, #e8dfd0 100%);
        }

        .btn-primary-landing {
            background-color: #c62828;
            color: white;
            padding: 14px 48px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.02em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(198, 40, 40, 0.3);
        }
        .btn-primary-landing:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(198, 40, 40, 0.4);
        }

        .btn-masuk {
            background-color: #c62828;
            color: white;
            padding: 8px 24px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-masuk:hover {
            background-color: #b71c1c;
        }

        .btn-daftar {
            border: 1.5px solid #374151;
            color: #374151;
            padding: 8px 24px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-daftar:hover {
            background-color: #374151;
            color: white;
        }

        .nav-link-landing {
            color: #374151;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }
        .nav-link-landing:hover {
            color: #c62828;
        }

        .nav-dot {
            width: 4px;
            height: 4px;
            background-color: #9ca3af;
            border-radius: 50%;
            display: inline-block;
        }

        /* Fade-in animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animate-delay-1 { animation-delay: 0.15s; }
        .animate-delay-2 { animation-delay: 0.3s; }
        .animate-delay-3 { animation-delay: 0.5s; }

        /* Section transitions */
        .section-fade {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .section-fade.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile menu styles */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .mobile-menu.open {
            max-height: 400px;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-transparent">
        <div class="cont py-5 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="images/global/logoperpus.png" alt="E-Perpus Logo" class="h-10 w-auto">
            </div>

            <!-- Center Nav Links (Desktop) -->
            <div class="hidden md:flex items-center gap-5">
                <a href="#popular" class="nav-link-landing">Eksplorasi</a>
                <span class="nav-dot"></span>
                <a href="#about" class="nav-link-landing">Tentang</a>
                <span class="nav-dot"></span>
                <a href="#maps" class="nav-link-landing">FAQ</a>
            </div>

            <!-- Right Auth Buttons (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-masuk">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('student.home') }}" class="btn-masuk">
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-700 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu md:hidden bg-white/95 backdrop-blur-md border-b border-gray-200">
            <div class="cont py-4 flex flex-col gap-4">
                <a href="#popular" class="nav-link-landing">Eksplorasi</a>
                <a href="#about" class="nav-link-landing">Tentang</a>
                <a href="#maps" class="nav-link-landing">FAQ</a>
                <div class="flex gap-3 pt-2 border-t border-gray-200">
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

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="cont text-center px-4 pt-20">
            <h1 class="font-playfair text-5xl sm:text-6xl md:text-7xl lg:text-[5.5rem] font-bold text-gray-900 leading-tight opacity-0 animate-fade-in-up">
                Selamat Datang di
            </h1>
            <h1 class="font-playfair text-5xl sm:text-6xl md:text-7xl lg:text-[5.5rem] font-bold text-gray-900 leading-tight mt-1 opacity-0 animate-fade-in-up animate-delay-1">
                E-Perpus SMKDA
            </h1>

            <p class="mt-8 text-gray-600 text-base sm:text-lg max-w-xl mx-auto leading-relaxed opacity-0 animate-fade-in-up animate-delay-2">
                Platform digital untuk membaca buku-buku tentang
                pengetahuan menarik, ilmu berguna, dan ide-ide yang relevan.
            </p>

            <div class="mt-10 opacity-0 animate-fade-in-up animate-delay-3">
                @auth
                    <a href="{{ route('student.home') }}" class="btn-primary-landing inline-block">
                        Mulai Membaca
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary-landing inline-block">
                        Mulai Membaca
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Popular Books Section -->
    <section id="popular" class="py-24 bg-background border-t border-gray-200 section-fade">
        <div class="cont">
            <div class="text-center mb-14">
                <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Koleksi Pilihan</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-bold text-text">Buku Terpopuler</h2>
                <p class="text-text/50 text-lg mt-3 max-w-lg mx-auto">Paling banyak dipinjam oleh siswa SMKN 2 Purwakarta</p>
            </div>

            <div class="flex justify-center gap-10 flex-wrap">
                @foreach ($popularBooks as $book)
                    <x-book-cover :book="$book" :large="true" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-gray-50 border-t border-gray-200 section-fade">
        <div class="cont">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Tentang Kami</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-bold text-text leading-tight">
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
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                        <div class="text-4xl font-bold text-primary font-playfair">500+</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Koleksi Buku</div>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                        <div class="text-4xl font-bold text-primary font-playfair">200+</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Siswa Aktif</div>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                        <div class="text-4xl font-bold text-primary font-playfair">50+</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Kategori</div>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                        <div class="text-4xl font-bold text-primary font-playfair">24/7</div>
                        <div class="text-text/60 mt-2 text-sm font-medium">Akses Digital</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Maps Section -->
    <section id="maps" class="py-24 bg-background border-t border-gray-200 section-fade">
        <div class="cont">
            <div class="text-center mb-14">
                <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Lokasi</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-bold text-text mb-2">Temukan Kami</h2>
                <p class="text-text/50 text-lg">SMKN 2 Purwakarta, Jawa Barat</p>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-lg h-126 border border-gray-200">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.77000106877!2d107.43932322577727!3d-6.550696643442323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690e5975014a5d%3A0x87f7a97e7f9f961!2sSMKN%202%20Purwakarta!5e0!3m2!1sid!2sid!4v1769698917066!5m2!1sid!2sid"
                    class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="py-24 hero-gradient section-fade">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <p class="text-primary font-semibold tracking-widest text-sm uppercase mb-3">Feedback</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kirim Pendapat Anda</h2>
                    <p class="text-gray-600 text-lg">Bantu kami menjadi lebih baik</p>
                </div>

                <div class="bg-white/60 backdrop-blur-md rounded-3xl p-8 md:p-10 shadow-xl border border-white/50">
                    <form class="space-y-6">
                        <div>
                            <input type="email" placeholder="Email kamu"
                                class="w-full px-6 py-4 rounded-full bg-white text-text placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/40 border border-gray-200 transition">
                        </div>
                        <div>
                            <textarea rows="5" placeholder="Pesan kamu..."
                                class="w-full px-6 py-4 rounded-2xl bg-white text-text placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/40 border border-gray-200 transition resize-none"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-primary-landing">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 border-t border-white/10">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <div>
                    <h3 class="font-playfair text-2xl font-bold text-white mb-4">E-PERPUS</h3>
                    <p class="text-white/60 leading-relaxed">SMKN 2 Purwakarta<br>Perpustakaan Digital Modern untuk mendukung kegiatan belajar mengajar.</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-5 text-white/90">Quick Links</h4>
                    <ul class="space-y-3 text-white/60">
                        <li><a href="#" class="hover:text-primary transition">Beranda</a></li>
                        <li><a href="#popular" class="hover:text-primary transition">Katalog</a></li>
                        <li><a href="#about" class="hover:text-primary transition">Tentang</a></li>
                        <li><a href="#maps" class="hover:text-primary transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-5 text-white/90">Kontak</h4>
                    <ul class="space-y-3 text-white/60">
                        <li class="flex items-center gap-3">
                            <span class="text-primary">📧</span> perpus@smkn2pwk.sch.id
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-primary">📞</span> (0264) 123456
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-primary">📍</span> Purwakarta, Jawa Barat
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 text-center text-white/40 text-sm">
                <p>&copy; 2025 E-Perpus SMKN 2 Purwakarta. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn?.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
        });

        // Section fade-in on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.section-fade').forEach(el => observer.observe(el));
    </script>

</body>

</html>
