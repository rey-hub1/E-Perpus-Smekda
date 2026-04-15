<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background min-h-screen flex">

    
    <div class="hidden lg:flex lg:w-[45%] bg-primary flex-col justify-between p-12 relative overflow-hidden">

        
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 -right-32 w-72 h-72 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-20 left-1/3 w-56 h-56 rounded-full bg-white/5"></div>

        
        <div class="relative z-10">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-16 w-auto object-contain brightness-0 invert">
                <span class="text-white font-bold text-xl font-heading tracking-tight">GoRead</span>
            </a>
        </div>

        
        <div class="relative z-10 space-y-8">

            
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

        
        <div class="relative z-10">
            <p class="text-white/30 text-xs">© {{ date('Y') }} GoRead — SMEKDA Library</p>
        </div>
    </div>

    
    <div class="flex-1 flex flex-col justify-center px-8 sm:px-12 lg:px-16 xl:px-24 py-10 overflow-y-auto">

        
        <div class="lg:hidden mb-8">
            <a href="/" class="flex items-center gap-2.5">
                <img src="{{ asset('images/global/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain">
                <span class="font-bold text-lg text-text font-heading">GoRead</span>
            </a>
        </div>

        <div class="w-full max-w-sm mx-auto">

            
            <div class="mb-7">
                <h1 class="text-2xl font-bold font-heading text-text">Buat akun baru</h1>
                <p class="text-sm text-text/40 mt-1.5">Daftar gratis dan mulai pinjam buku hari ini.</p>
            </div>

            
            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-text/70 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Budi Santoso"
                        class="w-full border @error('name') border-primary @else border-text/10 @enderror rounded-xl px-4 py-3 text-sm text-text placeholder-text/30 bg-background focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        required>
                    @error('name')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text/70 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@sekolah.sch.id"
                        class="w-full border @error('email') border-primary @else border-text/10 @enderror rounded-xl px-4 py-3 text-sm text-text placeholder-text/30 bg-background focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
                        required>
                    @error('email')
                        <p class="text-xs text-primary mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text/70 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="passwordInput"
                            placeholder="Minimal 6 karakter"
                            class="w-full border @error('password') border-primary @else border-text/10 @enderror rounded-xl px-4 py-3 text-sm text-text placeholder-text/30 bg-background focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all pr-11"
                            required>
                        <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon1')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-text/30 hover:text-text/60 transition-colors">
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
                    <label class="block text-sm font-medium text-text/70 mb-1.5">Ulangi Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="confirmInput"
                            placeholder="Ketik ulang password"
                            class="w-full border border-text/10 rounded-xl px-4 py-3 text-sm text-text placeholder-text/30 bg-background focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all pr-11"
                            required>
                        <button type="button" onclick="togglePassword('confirmInput', 'eyeIcon2')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-text/30 hover:text-text/60 transition-colors">
                            <svg id="eyeIcon2" class="w-4.5 h-4.5" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-secondary text-background font-semibold py-3 rounded-xl text-sm transition-colors mt-1 shadow-sm shadow-primary/20">
                    Buat Akun
                </button>
            </form>

            
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-text/5"></div>
                <span class="text-xs text-text/30">atau</span>
                <div class="flex-1 h-px bg-text/5"></div>
            </div>

            
            <p class="text-center text-sm text-text/40">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline ml-1">Masuk di sini</a>
            </p>

            
            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-xs text-text/20 hover:text-text/50 transition-colors font-medium">
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
