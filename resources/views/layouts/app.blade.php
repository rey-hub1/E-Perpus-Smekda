<!DOCTYPE html>
@php use Illuminate\Support\Facades\Storage; @endphp
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoRead') | GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen overflow-hidden bg-background">

    <!-- Sidebar Navigation -->
    <nav class="w-60 flex flex-col bg-white border-r border-gray-100 shadow-sm">

        <!-- Logo Section -->
        <a href="{{ route('landing') }}" class="px-5 py-5 flex items-center gap-3 border-b border-gray-100">
            <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain shrink-0">
            <div>
                <h1 class="text-sm font-bold text-text leading-none" style="font-family: var(--font-heading);">GoRead</h1>
                <p class="text-[10px] text-text/40 mt-0.5">Perpustakaan Digital</p>
            </div>
        </a>

        <!-- Navigation Links -->
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <!-- Home -->
            <a href="{{ route('student.home') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('student.home') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <!-- Home/house icon -->
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
                <span>Beranda</span>
            </a>

            <!-- Katalog Buku -->
            <a href="{{ route('student.katalog') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('student.katalog') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <!-- Search/magnifying glass icon -->
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"/>
                </svg>
                <span>Katalog Buku</span>
            </a>

            <!-- Library -->
            <a href="{{ route('library') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('library') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <!-- Bookmark icon -->
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                </svg>
                <span>Koleksi Saya</span>
            </a>

            <!-- Riwayat Pinjam -->
            <a href="{{ route('student.history') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('student.history') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <!-- Clock/history icon -->
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v5h5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l4 2"/>
                </svg>
                <span>Riwayat Pinjam</span>
            </a>

        </div>

        <!-- User Profile + Logout -->
        <div class="px-3 py-3 border-t border-gray-100 space-y-1">

            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors
                {{ request()->routeIs('profile') ? 'bg-primary/10' : 'hover:bg-gray-50' }}">
                @if (auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                         class="w-7 h-7 rounded-full object-cover shrink-0 ring-2 ring-primary/20" alt="avatar">
                @else
                    <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0" style="background: #DC2626;">
                        <span class="text-xs font-bold text-white leading-none">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-text truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-text/40 truncate">Lihat profil</p>
                </div>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-text/50 hover:bg-red-50 hover:text-primary transition-colors">
                    <!-- Logout icon -->
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto h-screen">
        <div class="py-6 @yield('content-padding', 'px-8')">
            @yield('content')
        </div>
    </main>

</body>

</html>
