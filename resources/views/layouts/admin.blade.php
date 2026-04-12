<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
</head>

<body class="flex h-screen overflow-hidden bg-background">

    <!-- Sidebar -->
    <aside class="w-56 shrink-0 flex flex-col" style="background: #111827;">

        <!-- Logo -->
        <div class="px-5 py-5 flex items-center gap-3" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
            <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain shrink-0">
            <div>
                <p class="text-sm font-bold leading-none" style="color: #f9fafb; font-family: var(--font-heading);">GoRead</p>
                <p class="text-[10px] uppercase tracking-widest mt-0.5" style="color: rgba(255,255,255,0.3);">Admin Panel</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <!-- Section label -->
            <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-widest" style="color: rgba(255,255,255,0.25);">Menu</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'hover:bg-white/5' }}"
                style="{{ request()->routeIs('admin.dashboard') ? 'background: #DC2626; color: #fff;' : 'color: rgba(255,255,255,0.5);' }}">
                <!-- Home icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.books.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.books.*') ? 'text-white' : 'hover:bg-white/5' }}"
                style="{{ request()->routeIs('admin.books.*') ? 'background: #DC2626; color: #fff;' : 'color: rgba(255,255,255,0.5);' }}">
                <!-- Book icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                </svg>
                Koleksi Buku
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'hover:bg-white/5' }}"
                style="{{ request()->routeIs('admin.categories.*') ? 'background: #DC2626; color: #fff;' : 'color: rgba(255,255,255,0.5);' }}">
                <!-- Tag icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('admin.transactions') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.transactions') ? 'text-white' : 'hover:bg-white/5' }}"
                style="{{ request()->routeIs('admin.transactions') ? 'background: #DC2626; color: #fff;' : 'color: rgba(255,255,255,0.5);' }}">
                <!-- Arrow swap icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4 4 4M17 8v12m0 0 4-4m-4 4-4-4"/>
                </svg>
                Transaksi
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.users.*') ? 'text-white' : 'hover:bg-white/5' }}"
                style="{{ request()->routeIs('admin.users.*') ? 'background: #DC2626; color: #fff;' : 'color: rgba(255,255,255,0.5);' }}">
                <!-- Users icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Anggota
            </a>

            <div class="pt-3 pb-1" style="border-top: 1px solid rgba(255,255,255,0.06); margin-top: 8px;">
                <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-widest" style="color: rgba(255,255,255,0.25);">Konfigurasi</p>
            </div>

            <a href="{{ route('admin.icons.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.icons.*') ? 'text-white' : 'hover:bg-white/5' }}"
                style="{{ request()->routeIs('admin.icons.*') ? 'background: #DC2626; color: #fff;' : 'color: rgba(255,255,255,0.5);' }}">
                <!-- Sparkles icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z"/>
                </svg>
                Kelola Icon
            </a>

        </nav>

        <!-- User & Logout -->
        <div class="px-3 py-3" style="border-top: 1px solid rgba(255,255,255,0.07);">
            <div class="px-3 py-2.5 rounded-lg mb-1 flex items-center gap-3" style="background: rgba(255,255,255,0.05);">
                <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0" style="background: #DC2626;">
                    <span class="text-xs font-bold text-white">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold truncate" style="color: #f9fafb;">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] truncate" style="color: rgba(255,255,255,0.3);">Administrator</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/5"
                    style="color: rgba(255,255,255,0.4);">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Topbar -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shrink-0">
            <div>
                <h1 class="text-base font-semibold text-text">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-text/40 mt-0.5">@yield('page-subtitle', 'Panel administrasi perpustakaan')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-text/40">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto px-8 py-6">
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @stack('scripts')
</body>

</html>
