<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMeja = Meja::count();
        $totalMenu = Menu::count();
        $menungguKonfirmasi = Reservasi::where('status_reservasi', 'menunggu_konfirmasi')->count();
        $totalReservasi = Reservasi::count();

        return view('admin.dashboard', compact('totalMeja', 'totalMenu', 'menungguKonfirmasi', 'totalReservasi'));
    }
}