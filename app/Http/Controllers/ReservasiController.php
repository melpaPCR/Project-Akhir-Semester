<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    // 1. Halaman Form Reservasi & Filter Meja Tersedia
    public function index(Request $request)
    {
        $mejaTersedia = Meja::where('status', 'tersedia')->get();

        if ($request->filled(['tanggal_reservasi', 'waktu_reservasi', 'jumlah_tamu'])) {
            $mejaTerbooking = Reservasi::where('tanggal_reservasi', $request->tanggal_reservasi)
                ->where('waktu_reservasi', $request->waktu_reservasi)
                ->whereNotIn('status_reservasi', ['dibatalkan', 'selesai'])
                ->pluck('id_meja');

            $mejaTersedia = Meja::where('status', 'tersedia')
                ->where('kapasitas', '>=', $request->jumlah_tamu)
                ->whereNotIn('id_meja', $mejaTerbooking)
                ->get();
        }

        return view('pelanggan.reservasi', compact('mejaTersedia'));
    }

    // 2. Simpan Data Reservasi Meja
    public function store(Request $request)
    {
        $request->validate([
            'id_meja' => 'required|exists:meja,id_meja',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'waktu_reservasi' => 'required',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        $reservasi = Reservasi::create([
            'id_user' => Auth::id(),
            'id_meja' => $request->id_meja,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'waktu_reservasi' => $request->waktu_reservasi,
            'jumlah_tamu' => $request->jumlah_tamu,
            'status_reservasi' => 'menunggu_pembayaran',
        ]);

        return redirect('/reservasi/' . $reservasi->id_reservasi . '/pesan-menu')
            ->with('success', 'Meja berhasil dipilih! Silakan pilih menu pesanan Anda.');
    }

    // 3. Halaman Pilih Menu (Pre-Order)
    public function pesanMenu($id)
    {
        $reservasi = Reservasi::with('meja')->findOrFail($id);
        $menus = Menu::all();

        return view('pelanggan.pesan_menu', compact('reservasi', 'menus'));
    }

    // 4. Simpan Daftar Menu yang Dipesan
    public function simpanMenu(Request $request, $id)
    {
        $request->validate([
            'menu' => 'required|array',
        ]);

        foreach ($request->menu as $id_menu => $jumlah) {
            if ($jumlah > 0) {
                $menu = Menu::findOrFail($id_menu);
                Pesanan::create([
                    'id_reservasi' => $id,
                    'id_menu' => $id_menu,
                    'jumlah' => $jumlah,
                    'subtotal' => $menu->harga * $jumlah,
                ]);
            }
        }

        return redirect('/reservasi/' . $id . '/pembayaran')
            ->with('success', 'Pesanan menu disimpan! Silakan selesaikan pembayaran.');
    }

    // 5. Halaman Pembayaran & Ringkasan Tagihan
    public function pembayaran($id)
    {
        $reservasi = Reservasi::with(['meja', 'pesanan.menu'])->findOrFail($id);
        $totalBayar = $reservasi->pesanan->sum('subtotal');

        return view('pelanggan.pembayaran', compact('reservasi', 'totalBayar'));
    }

    // 6. Proses Upload Bukti Pembayaran
    public function prosesPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $reservasi->update([
            'bukti_pembayaran' => $path,
            'status_reservasi' => 'menunggu_konfirmasi',
        ]);

        return redirect('/riwayat')->with('success', 'Bukti pembayaran berhasil diunggah!');
    }

    // 7. Halaman Riwayat Reservasi Pelanggan
    public function riwayat()
    {
        $reservasis = Reservasi::with(['meja', 'pesanan.menu'])
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

        return view('pelanggan.riwayat', compact('reservasis'));
    }
}