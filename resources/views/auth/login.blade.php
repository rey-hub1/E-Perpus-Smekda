<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex">

    <!-- Left Panel: Branding -->
    <div class="hidden lg:flex lg:w-[45%] bg-primary flex-col justify-between p-12 relative overflow-hidden">

        <!-- Decorative circles -->
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 -right-32 w-72 h-72 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-20 left-1/3 w-56 h-56 rounded-full bg-white/5"></div>

        <!-- Logo -->
        <div class="relative z-10">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-16 w-auto object-contain brightness-0 invert">
                <span class="text-white font-bold text-xl font-heading tracking-tight">GoRead</span>
            </a>
        </div>

        <!-- Center Content -->
        <div class="relative z-10 space-y-8">

            <!-- Ilustrasi buku-buku -->
            <div class="flex gap-3 items-end">
                <div class="w-14 h-20 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 shadow-lg"></div>
                <div class="w-14 h-24 rounded-lg bg-white/30 backdrop-blur-sm border border-white/30 shadow-lg"></div>
                <div class="w-14 h-16 rounded-lg bg-white/15 backdrop-blur-sm border border-white/20 shadow-lg"></div>
                <div class="w-14 h-28 rounded-lg bg-white/25 backdrop-blur-sm border border-white/30 shadow-lg"></div>
                <div class="w-14 h-20 rounded-lg bg-white/20 backdrop-blur-sm border border-white/25 shadow-lg"></div>
            </div>

            <div>
                <h2 class="text-4xl font-bold font-heading text-white leading-snug">
                    Ribuan buku<br>menunggu kamu.
                </h2>
                <p class="text-white/60 mt-4 text-base leading-relaxed">
                    Pinjam, baca, dan kembalikan dengan mudah. Semua koleksi perpustakaan ada di satu tempat.
                </p>
            </div>

            <!-- Stats -->
            <div class="flex gap-8">
                <div>
                    <p class="text-2xl font-bold text-white">500+</p>
                    <p class="text-xs text-white/50 mt-0.5 uppercase tracking-wider">Koleksi Buku</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <p class="text-2xl font-bold text-white">1.200+</p>
                    <p class="text-xs text-white/50 mt-0.5 uppercase tracking-wider">Anggota Aktif</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="relative z-10">
            <p class="text-white/30 text-xs">© {{ date('Y') }} GoRead — SMEKDA Library</p>
        </div>
    </div>

    <!-- Right Panel: Form -->
    <div class="flex-1 flex flex-col justify-center px-8 sm:px-12 lg:px-16 xl:px-24">

        <!-- Mobile logo -->
        <div class="lg:hidden mb-10">
            <a href="/" class="flex items-center gap-2.5">
                <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain">
                <span class="font-bold text-lg text-gray-900 font-heading">GoRead</span>
            </a>
        </div>

        <div class="w-full max-w-sm mx-auto">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold font-heading text-text">Masuk ke akun kamu</h1>
                <p class="text-sm text-text/40 mt-1.5">Gunakan email dan password yang sudah terdaftar.</p>
            </div>

            <!-- Error -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3.5 mb-6 flex items-center gap-3">
                    <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <p class="text-sm text-primary font-medium">{{ $errors->first() }}</p>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@sekolah.sch.id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        required autofocus>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="passwordInput"
                            placeholder="Masukkan password kamu"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all pr-11"
                            required>
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="eyeIcon" class="w-4.5 h-4.5" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-secondary text-background font-semibold py-3 rounded-xl text-sm transition-colors mt-2 shadow-sm shadow-primary/20">
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-100"></div>
                <span class="text-xs text-gray-400">atau</span>
                <div class="flex-1 h-px bg-gray-100"></div>
            </div>

            <!-- Register link -->
            <p class="text-center text-sm text-text/40">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline ml-1">Daftar sekarang</a>
            </p>

            <!-- Back to home -->
            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-300 hover:text-gray-500 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Kembali ke halaman depan
                </a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                `;
            }
        }
    </script>

</body>
</html>
