<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoRead - Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">

    <nav class="bg-primary shadow-lg text-white sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">

            <a href="/" class="text-2xl font-bold flex items-center gap-2 hover:text-accent transition">
                📚 GoRead
            </a>

            <div class="flex items-center gap-6">

                @auth
                    <div class="hidden md:flex gap-6 text-sm font-medium">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('books.index') }}" class="hover:text-cta transition {{ request()->routeIs('books.*') ? 'text-cta border-b-2 border-cta' : '' }}">
                                Kelola Buku
                            </a>
                            <a href="{{ route('admin.transactions') }}" class="hover:text-cta transition {{ request()->routeIs('admin.transactions') ? 'text-cta border-b-2 border-cta' : '' }}">
                                Laporan Transaksi
                            </a>
                        @elseif(Auth::user()->role == 'siswa')
                            <a href="{{ route('student.dashboard') }}" class="hover:text-cta transition {{ request()->routeIs('student.dashboard') ? 'text-cta border-b-2 border-cta' : '' }}">
                                Katalog
                            </a>
                            <a href="{{ route('student.history') }}" class="hover:text-cta transition {{ request()->routeIs('student.history') ? 'text-cta border-b-2 border-cta' : '' }}">
                                Buku Saya
                            </a>
                        @endif
                    </div>

                    <div class="h-6 w-px bg-white/20 mx-2 hidden md:block"></div>

                    <div class="flex items-center gap-4">
                        <span class="text-sm hidden md:inline opacity-90">
                            Halo, <span class="font-bold text-accent">{{ Auth::user()->name }}</span>
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500/20 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold transition border border-red-500/50">
                                Logout
                            </button>
                        </form>
                    </div>

                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="hover:text-accent font-medium transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-cta text-primary px-5 py-2 rounded-lg font-bold hover:bg-yellow-400 transition shadow">
                            Daftar Anggota
                        </a>
                    </div>
                @endauth

            </div>
        </div>
    </nav>

    <main class="container mx-auto p-6 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-primary text-white text-center p-6 mt-auto border-t border-white/10">
        <p class="opacity-80 text-sm">
            &copy; 2026 <strong>GoRead Library</strong>. Membaca Jendela Dunia.
        </p>
    </footer>

</body>
</html>
