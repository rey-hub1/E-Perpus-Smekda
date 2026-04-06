<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->with('book')->latest()->get();

        $dipinjam     = $transactions->where('status', 'dipinjam')->count();
        $dikembalikan = $transactions->where('status', 'dikembalikan')->count();
        $terlambat    = $transactions->filter(fn($t) =>
            $t->status === 'dipinjam' && $t->due_date && now()->gt($t->due_date)
        )->count();

        return view('profile.show', compact('user', 'dipinjam', 'dikembalikan', 'terlambat'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'nisn'   => 'nullable|string|max:20',
            'kelas'  => 'nullable|string|max:50',
            'phone'  => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->nisn  = $request->nisn;
        $user->kelas = $request->kelas;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withFragment('password');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success_password', 'Password berhasil diubah.')->withFragment('password');
    }
}
