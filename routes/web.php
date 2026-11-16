<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, AuthController, ReservasiController};
use App\Http\Controllers\Admin\{DashboardController, MejaController, MenuController, ReservasiAdminController};

// --- HALAMAN PUBLIC / GUEST ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu.public');
Route::get('/cek-meja', [HomeController::class, 'cekMeja'])->name('meja.cek');

// --- AUTH (LOGIN & REGISTRASI DALAM 1 HALAMAN SESUAI PROTOTIPE) ---
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- HALAMAN PELANGGAN (WAJIB LOGIN) ---
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/{id}/pesan-menu', [ReservasiController::class, 'pesanMenu'])->name('reservasi.menu');
    Route::post('/reservasi/{id}/pesan-menu', [ReservasiController::class, 'simpanMenu'])->name('reservasi.menu.simpan');
    Route::get('/reservasi/{id}/pembayaran', [ReservasiController::class, 'pembayaran'])->name('reservasi.bayar');
    Route::post('/reservasi/{id}/pembayaran', [ReservasiController::class, 'prosesPembayaran'])->name('reservasi.bayar.proses');
    Route::get('/riwayat', [ReservasiController::class, 'riwayat'])->name('pelanggan.riwayat');
});

// --- HALAMAN ADMIN (WAJIB LOGIN & ROLE ADMIN) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/meja', MejaController::class);
    Route::resource('/menu', MenuController::class);
    Route::get('/reservasi', [ReservasiAdminController::class, 'index'])->name('reservasi.index');
    Route::patch('/reservasi/{id}/konfirmasi', [ReservasiAdminController::class, 'konfirmasi'])->name('reservasi.konfirmasi');
});