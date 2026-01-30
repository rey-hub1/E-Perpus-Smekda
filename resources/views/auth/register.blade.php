<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary flex items-center justify-center min-h-screen py-10">

    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md border-t-8 border-cta">
        <h2 class="text-3xl font-bold text-center text-primary mb-2">Daftar Anggota 📝</h2>
        <p class="text-center text-gray-500 mb-6">Bergabunglah untuk mulai meminjam buku.</p>

        <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-primary font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent" placeholder="Contoh: Budi Santoso" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-primary font-bold mb-2">Email Sekolah</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent" placeholder="nama@sekolah.sch.id" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-primary font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent" placeholder="Minimal 6 karakter" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-primary font-bold mb-2">Ulangi Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent" placeholder="Ketik ulang password tadi" required>
            </div>

            <button type="submit" class="w-full bg-cta text-primary font-bold py-3 rounded-lg hover:bg-yellow-400 transition shadow-lg mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-400">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Login di sini</a>
        </div>
    </div>

</body>
</html>
