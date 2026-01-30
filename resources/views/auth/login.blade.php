<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoRead</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md border-t-8 border-cta">
        <h2 class="text-3xl font-bold text-center text-primary mb-2">Selamat Datang 👋</h2>
        <p class="text-center text-gray-500 mb-8">Silakan login untuk masuk ke perpustakaan.</p>

        <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-primary font-bold mb-2">Email Address</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent" placeholder="admin@goread.com" required>
            </div>

            <div>
                <label class="block text-primary font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent" placeholder="********" required>
            </div>

            @if ($errors->any())
                <div class="text-red-500 text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-secondary transition shadow-lg">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="/" class="text-gray-400 hover:text-primary">Kembali ke Halaman Depan</a>
        </div>
    </div>

</body>
</html>
