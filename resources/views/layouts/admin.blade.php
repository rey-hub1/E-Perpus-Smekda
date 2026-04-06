<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
</head>

<body class="flex h-screen overflow-hidden bg-background">

    <!-- Sidebar Navigation -->
    <nav class="w-54 flex flex-col shadow-sm border-r border-gray-200 bg-white">

        <!-- Logo Section - Sticky di atas -->
        <div class="sticky top-0 z-10 px-6 py-4 border-b border-gray-200 bg-white">
            <div class="flex flex-col items-center gap-2">
                <img src="/images/global/perpus_smekda.png" class="w-24" alt="Perpus SMEKDA">
                <h1 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Admin Panel</h1>
            </div>
        </div>

        <!-- Navigation Links - Scrollable -->
        <div class="flex-1 overflow-y-auto">
            <main class="flex flex-col gap-2 p-4">

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="group-hover:scale-110 transition-transform">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    </svg>
                    <span class="font-semibold">Dashboard</span>
                </a>

                <!-- Buku -->
                <a href="{{ route('admin.books.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('admin.books.*') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="group-hover:scale-110 transition-transform">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a2.5 2.5 0 0 1 0-5H20"/>
                    </svg>
                    <span class="font-semibold">Koleksi Buku</span>
                </a>

                <!-- Kategori -->
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="group-hover:scale-110 transition-transform">
                        <rect width="20" height="20" x="2" y="2" rx="2" ry="2" />
                        <path d="M7 2v20" />
                        <path d="M17 2v20" />
                        <path d="M2 12h20" />
                    </svg>
                    <span class="font-semibold">Manajemen Kategori</span>
                </a>

                <!-- Transaksi -->
                <a href="{{ route('admin.transactions') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('admin.transactions') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="group-hover:scale-110 transition-transform">
                        <path d="M12 7v14" />
                        <path d="M16 12h2" />
                        <path d="M16 8h2" />
                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                        <path d="M6 12h2" />
                        <path d="M6 8h2" />
                    </svg>
                    <span class="font-semibold">Transaksi</span>
                </a>

                <!-- Anggota -->
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:scale-105
                    {{ request()->routeIs('admin.users.*') ? 'bg-primary text-background shadow-md' : 'text-text hover:shadow-sm' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="group-hover:scale-110 transition-transform">
                        <path d="M18 20a6 6 0 0 0-12 0" />
                        <circle cx="12" cy="10" r="4" />
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                    <span class="font-semibold">Anggota</span>
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
        <div class="sticky bottom-0 p-4 border-t border-gray-200 text-center bg-white">
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

    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @stack('scripts')
</body>

</html>
