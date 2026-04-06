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
    <nav class="w-64 flex flex-col shadow-sm border-r border-gray-200 bg-white">

        <!-- Logo Section - Sticky di atas -->
        <a href="{{ route('landing') }}" class="sticky top-0 z-10 px-6 py-4 border-b border-gray-200 bg-white">
            <div class="flex flex-col items-center gap-2">
                <img src="/images/global/perpus_smekda.png" class="w-24" alt="Perpus SMEKDA">
                <div class="text-center">
                    <h1 class="text-sm font-bold text-gray-800">GoRead</h1>
                    <p class="text-xs text-gray-400">Perpustakaan Digital</p>
                </div>
            </div>
        </a>

        <!-- Navigation Links - Scrollable -->
        <div class="flex-1 overflow-y-auto">
            <main class="flex flex-col gap-2 p-4">

                <!-- Home -->
                <a href="{{ route('student.home') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('student.home') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                        <path
                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20" />
                    </svg>
                    <span class="font-semibold">Home</span>
                </a>
                <!-- Katalog Buku -->
                <a href="{{ route('student.katalog') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('student.katalog') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                        <path
                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20" />
                    </svg>
                    <span class="font-semibold">Katalog Buku</span>
                </a>

                <!-- Riwayat Pinjam -->
                <a href="{{ route('student.history') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('student.history') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M12 7v5l4 2" />
                    </svg>
                    <span class="font-semibold">Riwayat Pinjam</span>
                </a>

                <!-- Profil -->
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('profile') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    @if (auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}"
                             class="w-5 h-5 rounded-full object-cover shrink-0" alt="avatar">
                    @else
                        <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center shrink-0">
                            <span class="text-[10px] font-black text-primary leading-none">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <span class="font-semibold">Profil</span>
                </a>

                <!-- Divider -->
                <div class="my-2 border-t border-primary/20"></div>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105 hover:shadow-sm text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="group-hover:scale-110 transition-transform">
                            <path d="m16 17 5-5-5-5" />
                            <path d="M21 12H9" />
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        </svg>
                        <span class="font-semibold">Logout</span>
                    </button>
                </form>
            </main>
        </div>

        <!-- Footer Copyright - Sticky di bawah -->
        <div class="sticky bottom-0 p-4 border-t border-gray-200 bg-white text-center">
            <p class="text-xs font-medium text-text/60">© 2024 SMEKDA Library</p>
            <p class="text-xs mt-1 text-text/40">All Rights Reserved</p>
        </div>
    </nav>

    <!-- Main Content Area - Scrollable -->
    <main class="flex-1 overflow-y-auto h-screen">
        <div class="px-8 py-6">
            @yield('content')
        </div>
    </main>

</body>

</html>
