<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiAdminController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::with(['user', 'meja', 'pesanan.menu'])->latest()->get();
        return view('admin.reservasi.index', compact('reservasis'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status_reservasi' => 'required|in:dikonfirmasi,dibatalkan,selesai',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status_reservasi' => $request->status_reservasi,
        ]);

        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }
}