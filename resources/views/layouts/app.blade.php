<!DOCTYPE html>
@php use Illuminate\Support\Facades\Storage; @endphp
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoRead') | GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background">

    {{-- ===== Mobile Top Bar (< lg) ===== --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40 h-14 bg-white border-b border-gray-100 flex items-center px-4 gap-3 shadow-sm">
        <button id="drawerToggle" class="p-1.5 rounded-lg hover:bg-gray-50 text-text/60 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>

        <a href="{{ route('landing') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain shrink-0">
            <span class="text-sm font-bold text-text" style="font-family: var(--font-heading);">GoRead</span>
        </a>

        <div class="ml-auto">
            <a href="{{ route('profile') }}" class="block">
                @if (auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                         class="w-8 h-8 rounded-full object-cover ring-2 ring-primary/20" alt="avatar">
                @else
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: #DC2626;">
                        <span class="text-xs font-bold text-white leading-none">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                @endif
            </a>
        </div>
    </header>

    {{-- ===== Mobile Drawer Overlay ===== --}}
    <div id="drawerOverlay" class="lg:hidden fixed inset-0 bg-black/40 z-30 opacity-0 pointer-events-none transition-opacity duration-300"></div>

    {{-- ===== Sidebar Navigation ===== --}}
    <nav id="sidebar" class="fixed top-0 left-0 h-full z-40 w-64 flex flex-col bg-white border-r border-gray-100 shadow-sm -translate-x-full lg:translate-x-0 transition-transform duration-300">

        {{-- Logo Section --}}
        <a href="{{ route('landing') }}" class="px-5 py-5 flex items-center gap-3 border-b border-gray-100 shrink-0">
            <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain shrink-0">
            <div>
                <h1 class="text-sm font-bold text-text leading-none" style="font-family: var(--font-heading);">GoRead</h1>
                <p class="text-[10px] text-text/40 mt-0.5">Perpustakaan Digital</p>
            </div>
        </a>

        {{-- Navigation Links --}}
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <a href="{{ route('student.home') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('student.home') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('student.katalog') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('student.katalog') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"/>
                </svg>
                <span>Katalog Buku</span>
            </a>

            <a href="{{ route('library') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('library') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                </svg>
                <span>Koleksi Saya</span>
            </a>

            <a href="{{ route('student.history') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('student.history') ? 'bg-primary text-white' : 'text-text/60 hover:bg-gray-50 hover:text-text' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v5h5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l4 2"/>
                </svg>
                <span>Riwayat Pinjam</span>
            </a>

        </div>

        {{-- User Profile + Logout --}}
        <div class="px-3 py-3 border-t border-gray-100 space-y-1 shrink-0">

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
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    {{-- ===== Main Content Area ===== --}}
    <main class="lg:ml-64 min-h-screen">
        <div class="pt-14 lg:pt-0 pb-20 lg:pb-0">
            <div class="py-6 @yield('content-padding', 'px-4 sm:px-6 lg:px-8')">
                @yield('content')
            </div>
        </div>
    </main>

    {{-- ===== Mobile Bottom Navigation (< lg) ===== --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-30 bg-white border-t border-gray-100 shadow-[0_-1px_3px_rgba(0,0,0,0.05)] flex">

        <a href="{{ route('student.home') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 py-2 transition-colors
            {{ request()->routeIs('student.home') ? 'text-primary' : 'text-text/40 hover:text-text/70' }}">
            <svg class="w-5 h-5" fill="{{ request()->routeIs('student.home') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
            </svg>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>

        <a href="{{ route('student.katalog') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 py-2 transition-colors
            {{ request()->routeIs('student.katalog') ? 'text-primary' : 'text-text/40 hover:text-text/70' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('student.katalog') ? '2.5' : '2' }}" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"/>
            </svg>
            <span class="text-[10px] font-semibold">Katalog</span>
        </a>

        <a href="{{ route('library') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 py-2 transition-colors
            {{ request()->routeIs('library') ? 'text-primary' : 'text-text/40 hover:text-text/70' }}">
            <svg class="w-5 h-5" fill="{{ request()->routeIs('library') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
            </svg>
            <span class="text-[10px] font-semibold">Koleksi</span>
        </a>

        <a href="{{ route('student.history') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 py-2 transition-colors
            {{ request()->routeIs('student.history') ? 'text-primary' : 'text-text/40 hover:text-text/70' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs('student.history') ? '2.5' : '2' }}" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v5h5M12 7v5l4 2"/>
            </svg>
            <span class="text-[10px] font-semibold">Riwayat</span>
        </a>

    </nav>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('drawerOverlay');
        const toggle  = document.getElementById('drawerToggle');

        function openDrawer() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            document.body.style.overflow = '';
        }

        if (toggle) toggle.addEventListener('click', openDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);
    </script>

</body>

</html>
