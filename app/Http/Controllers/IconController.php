<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class IconController extends Controller
{
    public function index()
    {
        $icons = Icon::orderBy('label')->get();
        return view('admin.icons.index', compact('icons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'path'  => 'required|string',
        ], [
            'label.required' => 'Nama icon wajib diisi.',
            'path.required'  => 'SVG path wajib diisi.',
        ]);

        $slug = Str::slug($request->label, '-');
        $original = $slug;
        $i = 2;
        while (Icon::where('name', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        Icon::create([
            'name'  => $slug,
            'label' => $request->label,
            'path'  => $request->path,
        ]);

        Cache::forget('custom_icons');

        return back()->with('success', "Icon \"{$request->label}\" berhasil ditambahkan.");
    }

    public function destroy(Icon $icon)
    {
        $label = $icon->label;
        $icon->delete();
        Cache::forget('custom_icons');
        return back()->with('success', "Icon \"{$label}\" berhasil dihapus.");
    }
}
