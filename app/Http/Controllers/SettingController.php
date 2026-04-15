<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $loanDays = Setting::get('loan_days', 10);
        return view('admin.settings', compact('loanDays'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'loan_days' => ['required', 'integer', 'min:1', 'max:365'],
        ], [
            'loan_days.required' => 'Durasi peminjaman wajib diisi.',
            'loan_days.integer'  => 'Durasi peminjaman harus berupa angka.',
            'loan_days.min'      => 'Durasi peminjaman minimal 1 hari.',
            'loan_days.max'      => 'Durasi peminjaman maksimal 365 hari.',
        ]);

        Setting::set('loan_days', $request->loan_days);

        return back()->with('success', "Durasi peminjaman berhasil diubah menjadi {$request->loan_days} hari.");
    }
}
