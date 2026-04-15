<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'siswa')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $sedangPinjam = Transaction::where('user_id', $id)->where('status', 'dipinjam')->exists();

        if($sedangPinjam){
            return back()->with('error', 'Maaf tidak bisa menghapus karena siswa ini masih meminjam');
        }
        elseif ($user->role === 'admin'){
            return back()->with('error', 'Maaf tidak bisa menghapus atmin');
        }
        $user->delete();

        return back()->with('success', 'User Berhasil di Hapus');
    }
}
