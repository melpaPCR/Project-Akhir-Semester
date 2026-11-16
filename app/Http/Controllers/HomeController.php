<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function menu()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    public function cekMeja(Request $request)
    {
        $mejas = Meja::where('status', 'tersedia')->get();

        if ($request->filled(['tanggal_reservasi', 'waktu_reservasi'])) {
            $mejaTerbooking = Reservasi::where('tanggal_reservasi', $request->tanggal_reservasi)
                ->where('waktu_reservasi', $request->waktu_reservasi)
                ->whereNotIn('status_reservasi', ['dibatalkan', 'selesai'])
                ->pluck('id_meja');

            $mejas = Meja::where('status', 'tersedia')
                ->whereNotIn('id_meja', $mejaTerbooking)
                ->get();
        }

        return view('cek_meja', compact('mejas'));
    }
}