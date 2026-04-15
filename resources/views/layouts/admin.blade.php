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

    
    <aside class="w-56 shrink-0 flex flex-col bg-[#111827]">

        
        <div class="px-5 py-5 flex items-center gap-3 border-b border-white/7">
            <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain shrink-0">
            <div>
                <p class="text-sm font-bold leading-none text-[#f9fafb] font-heading">GoRead</p>
                <p class="text-[10px] uppercase tracking-widest mt-0.5 text-white/30">Admin Panel</p>
            </div>
        </div>

        
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            
            <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-widest text-white/25">Menu</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-white/50 hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.books.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.books.*') ? 'bg-primary text-white' : 'text-white/50 hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                </svg>
                Koleksi Buku
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white' : 'text-white/50 hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('admin.transactions') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.transactions') ? 'bg-primary text-white' : 'text-white/50 hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4 4 4M17 8v12m0 0 4-4m-4 4-4-4"/>
                </svg>
                Transaksi
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'text-white/50 hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Anggota
            </a>

        </nav>

        
        <div class="px-3 py-3 border-t border-white/7">
            <div class="px-3 py-2.5 rounded-lg mb-1 flex items-center gap-3 bg-white/5">
                <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 bg-primary">
                    <span class="text-xs font-bold text-white">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold truncate text-[#f9fafb]">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] truncate text-white/30">Administrator</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/5 text-white/40">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    
    <div class="flex-1 flex flex-col overflow-hidden">

        
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shrink-0">
            <div>
                <h1 class="text-base font-semibold text-text">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-text/40 mt-0.5">@yield('page-subtitle', 'Panel administrasi perpustakaan')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-text/40">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </header>

        
        <main class="flex-1 overflow-y-auto px-8 py-6">
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @stack('scripts')
</body>

</html>
