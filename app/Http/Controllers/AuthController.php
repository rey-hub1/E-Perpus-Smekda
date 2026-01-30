<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login & Cek Role
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // LOGIKA PEMISAHAN DASHBOARD DI SINI
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        // Kalau gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Email gak boleh kembar
            'password' => 'required|min:6|confirmed', // Password harus diketik 2x (konfirmasi)
        ]);

        // Buat User Baru (Otomatis jadi SISWA)
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'siswa', // Default role siswa
        ]);

        // Langsung Login otomatis setelah daftar
        Auth::login($user);

        // Arahkan ke dashboard siswa
        return redirect()->route('student.dashboard')->with('success', 'Selamat bergabung! Akun berhasil dibuat.');
    }
}
