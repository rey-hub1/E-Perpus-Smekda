<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — GoRead</title>
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
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl font-heading tracking-tight">GoRead</span>
            </a>
        </div>

        <!-- Center Content -->
        <div class="relative z-10 space-y-8">

            <!-- Feature list -->
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-white" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Jadwalkan Peminjaman</p>
                        <p class="text-white/50 text-xs mt-0.5 leading-relaxed">Pilih tanggal ambil dan lihat batas pengembalian secara otomatis.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-white" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Library Pribadi</p>
                        <p class="text-white/50 text-xs mt-0.5 leading-relaxed">Simpan buku favorit dan pantau daftar bacaanmu kapan saja.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-white" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Riwayat Peminjaman</p>
                        <p class="text-white/50 text-xs mt-0.5 leading-relaxed">Pantau status pinjaman dan tanggal pengembalian dengan mudah.</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-3xl font-bold font-heading text-white leading-snug">
                    Gabung sekarang.<br>Gratis untuk semua siswa.
                </h2>
            </div>
        </div>

        <!-- Footer -->
        <div class="relative z-10">
            <p class="text-white/30 text-xs">© {{ date('Y') }} GoRead — SMEKDA Library</p>
        </div>
    </div>

    <!-- Right Panel: Form -->
    <div class="flex-1 flex flex-col justify-center px-8 sm:px-12 lg:px-16 xl:px-24 py-10 overflow-y-auto">

        <!-- Mobile logo -->
        <div class="lg:hidden mb-8">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-white" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <span class="font-bold text-lg text-gray-900 font-heading">GoRead</span>
            </a>
        </div>

        <div class="w-full max-w-sm mx-auto">

            <!-- Header -->
            <div class="mb-7">
                <h1 class="text-2xl font-bold font-heading text-gray-900">Buat akun baru</h1>
                <p class="text-sm text-gray-400 mt-1.5">Daftar gratis dan mulai pinjam buku hari ini.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Budi Santoso"
                        class="w-full border @error('name') border-primary @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        required>
                    @error('name')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@sekolah.sch.id"
                        class="w-full border @error('email') border-primary @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        required>
                    @error('email')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="passwordInput"
                            placeholder="Minimal 6 karakter"
                            class="w-full border @error('password') border-primary @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all pr-11"
                            required>
                        <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon1')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="eyeIcon1" class="w-4.5 h-4.5" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ulangi Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="confirmInput"
                            placeholder="Ketik ulang password"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all pr-11"
                            required>
                        <button type="button" onclick="togglePassword('confirmInput', 'eyeIcon2')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="eyeIcon2" class="w-4.5 h-4.5" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-red-700 text-white font-semibold py-3 rounded-xl text-sm transition-colors mt-1 shadow-sm shadow-primary/20">
                    Buat Akun
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-100"></div>
                <span class="text-xs text-gray-400">atau</span>
                <div class="flex-1 h-px bg-gray-100"></div>
            </div>

            <!-- Login link -->
            <p class="text-center text-sm text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline ml-1">Masuk di sini</a>
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
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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
