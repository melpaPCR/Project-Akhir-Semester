<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('admin.meja.index', compact('mejas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        Meja::create($request->only(['nomor_meja', 'kapasitas', 'status']));

        return back()->with('success', 'Data meja berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Meja::findOrFail($id)->delete();
        return back()->with('success', 'Data meja berhasil dihapus.');
    }
}