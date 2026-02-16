<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpus SMKN 2 Purwakarta - Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-background">

    <!-- Navigation -->
    <nav class="fixed   top-0 left-0 w-full bg-background/95 backdrop-blur-sm shadow-md z-50 border-b border-primary/20">
        <div class="cont py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="images/global/logoperpus.png" alt="">
            </div>
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#" class="text-text font-medium hover:text-accent transition">Home</a>
                <a href="#popular" class="text-text font-medium hover:text-accent transition">Tentang</a>
                <a href="#maps" class="text-text font-medium hover:text-accent transition">Kontak</a>
                @auth
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-accent text-white px-6 py-2 rounded-full font-semibold hover:bg-accent/90 transition shadow-md">Dashboard
                            Admin</a>
                    @else
                        <a href="{{ route('student.dashboard') }}"
                            class="bg-accent text-white px-6 py-2 rounded-full font-semibold hover:bg-accent/90 transition shadow-md">Dashboard
                            Siswa</a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="bg-accent text-white px-6 py-2 rounded-full font-semibold hover:bg-accent/90 transition shadow-md">Login</a>
                @endauth
            </div>
            <!-- Mobile Menu Button -->
            <button class="md:hidden text-accent">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative pt-32 pb-20  overflow-hidden bg-gradient-to-br from-background via-background to-primary/10">
        <div class="container cont">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6 z-10">

                    <h1 class="text-5xl md:text-6xl font-bold text-text leading-tight">
                        PERPUSTAKAAN DIGITAL<br>
                        <span class="text-accent">SMKN 2 PURWAKARTA</span>
                    </h1>
                    <p class="text-lg text-text/80 max-w-xl">
                        Akses ribuan koleksi buku digital, jurnal, dan materi pembelajaran kapan saja, di mana saja.
                        Tingkatkan pengetahuanmu dengan mudah!
                    </p>
                    @guest
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="{{ route('login') }}"
                                class="bg-secondary text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-secondary/90 transform hover:scale-105 transition duration-300 shadow-lg">
                                Ayo Baca
                            </a>
                            <a href="#popular"
                                class="bg-primary text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-primary/90 transition duration-300">
                                Jelajahi Koleksi
                            </a>
                        </div>
                    @endguest
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="relative z-10">
                        <svg class="w-full h-auto max-w-md mx-auto" viewBox="0 0 400 400" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <!-- Stack of Books Illustration -->
                            <rect x="100" y="280" width="200" height="40" rx="4" fill="#283593" />
                            <rect x="80" y="240" width="240" height="40" rx="4" fill="#D32F2F" />
                            <rect x="90" y="200" width="220" height="40" rx="4" fill="#F57C00" />
                            <rect x="110" y="160" width="180" height="40" rx="4" fill="#388E3C" />

                            <!-- Book Details -->
                            <rect x="110" y="170" width="40" height="4" rx="2" fill="white"
                                opacity="0.3" />
                            <rect x="90" y="210" width="60" height="4" rx="2" fill="white"
                                opacity="0.3" />
                            <rect x="85" y="250" width="50" height="4" rx="2" fill="white"
                                opacity="0.3" />
                            <rect x="105" y="290" width="45" height="4" rx="2" fill="white"
                                opacity="0.3" />
                        </svg>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute top-10 right-10 w-32 h-32 bg-accent/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 left-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>

        <!-- Decorative Wave -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-24" preserveAspectRatio="none" viewBox="0 0 1200 120"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M0,0 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,120 L0,120 Z" fill="#DDA15E"
                    opacity="0.3"></path>
            </svg>
        </div>
    </section>

    <!-- Popular Books Section -->
    <section id="popular" class="py-20 bg-primary text-background">
        <div class="cont">
            <div class="text-center mb-12 flex flex-col">
                <h2 class="text-4xl font-bold ">Buku Terpopuler</h2>
                <p class=" text-lg">Buku Terpopuler Yang Banyak Orang Cari di Sini</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($favBook as $book)
                    <div class="flex flex-col gap-5 pt-3 overflow-hidden items-center group">
                        <img src="/images/{{ $book->gambar }}"
                            class="rounded-lg h-52 transition-transform duration-300 group-hover:scale-101 group-hover:-translate-y-1"
                            alt="">

                        <div
                            class="p-6 px-4 bg-background flex flex-col w-full h-fit rounded-lg transition-all duration-300
                            group-hover:-translate-y-1">
                            <div class="flex flex-col mb-3 ">
                                <h4 class="font-bold text-text ">{{ str($book->judul)->limit(40) }}</h4>
                                <p class="text-secondary text-xs">{{ $book->penulis }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-yellow-500 flex">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>


                                    </span>
                                    <span class="text-sm text-text/80 font-medium ml-2">10/10</span>
                                </div>
                                <button
                                    class="bg-accent p-1 px-2 rounded-xl font-semibold text-background/90 hover:text-background transition">
                                    Pinjam →
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Maps Section -->
    <section id="maps" class="py-20 bg-primar cont">
        <div class="container mx-auto ">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-background mb-4">MAPS</h2>
            </div>
            <div class="bg-secondary/20 rounded-3xl overflow-hidden shadow-xl h-126 flex items-center justify-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.77000106877!2d107.43932322577727!3d-6.550696643442323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690e5975014a5d%3A0x87f7a97e7f9f961!2sSMKN%202%20Purwakarta!5e0!3m2!1sid!2sid!4v1769698917066!5m2!1sid!2sid"
                    class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="py-20 bg-gradient-to-br from-text via-text/95 to-accent relative overflow-hidden">
        <!-- Library Background -->
        <div
            class="absolute inset-0 opacity-10 bg-[url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=1920')] bg-cover bg-center">
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold text-white mb-4 text-center">Send Us Your Opinion</h2>
                <p class="text-white/90 text-lg mb-8 text-center">About Us</p>

                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 shadow-2xl">
                    <form class="space-y-6">
                        <div>
                            <input type="email" placeholder="Type Your Email Here"
                                class="w-full px-6 py-4 rounded-full bg-white text-text placeholder-text/50 focus:outline-none focus:ring-4 focus:ring-primary/50 transition">
                        </div>
                        <div>
                            <textarea rows="5" placeholder="Your message..."
                                class="w-full px-6 py-4 rounded-3xl bg-white text-text placeholder-text/50 focus:outline-none focus:ring-4 focus:ring-primary/50 transition resize-none"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit"
                                class="bg-secondary text-white px-12 py-4 rounded-full font-bold text-lg hover:bg-secondary/90 transform hover:scale-105 transition duration-300 shadow-lg">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-text text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-accent mb-4">E-PERPUS</h3>
                    <p class="text-white/70">SMKN 2 Purwakarta</p>
                    <p class="text-white/70">Perpustakaan Digital Modern</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-white/70">
                        <li><a href="#" class="hover:text-accent transition">Tentang</a></li>
                        <li><a href="#" class="hover:text-accent transition">Katalog</a></li>
                        <li><a href="#" class="hover:text-accent transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-2 text-white/70">
                        <li>📧 perpus@smkn2pwk.sch.id</li>
                        <li>📞 (0264) 123456</li>
                        <li>📍 Purwakarta, Jawa Barat</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/20 pt-8 text-center text-white/60">
                <p>&copy; 2025 E-Perpus SMKN 2 Purwakarta. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>
