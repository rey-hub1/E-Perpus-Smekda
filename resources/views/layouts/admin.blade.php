<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
</head>

<body class="flex h-screen overflow-hidden bg-gray-50">

    <!-- Sidebar -->
    <aside class="w-60 shrink-0 flex flex-col bg-white border-r border-gray-200">

        <!-- Logo -->
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900 leading-none">GoRead</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">Admin Panel</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.books.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.books.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                </svg>
                Koleksi Buku
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('admin.transactions') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.transactions') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
                </svg>
                Transaksi
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                Anggota
            </a>

        </nav>

        <!-- User & Logout -->
        <div class="px-3 py-3 border-t border-gray-100 space-y-1">
            <div class="px-3 py-2 flex items-center gap-3">
                <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                    <span class="text-xs font-bold text-primary">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-gray-700 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-gray-400 truncate">Administrator</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 hover:bg-red-50 hover:text-primary transition-colors">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16 17 5-5-5-5M21 12H9M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
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
                <h1 class="text-base font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-gray-400 mt-0.5">@yield('page-subtitle', 'Panel administrasi perpustakaan')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400">{{ now()->translatedFormat('d F Y') }}</span>
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
