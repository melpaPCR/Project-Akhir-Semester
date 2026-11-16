<?php

namespace Database\Seeders;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin Restoran',
            'email' => 'admin@restoran.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Andi Pratama',
            'email' => 'andi@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'pelanggan',
        ]);

        Meja::insert([
            ['nomor_meja' => 'Meja 02', 'kapasitas' => 4, 'status' => 'tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['nomor_meja' => 'Meja 04', 'kapasitas' => 4, 'status' => 'tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['nomor_meja' => 'Meja 06', 'kapasitas' => 6, 'status' => 'tersedia', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Menu::insert([
            ['nama_menu' => 'Nasi Goreng Spesial', 'kategori' => 'Makanan', 'harga' => 45000, 'deskripsi' => 'Nasi goreng spesial dengan topping lengkap.', 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Ayam Bakar Madu', 'kategori' => 'Makanan', 'harga' => 52000, 'deskripsi' => 'Ayam bakar oles madu gurih manis.', 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Es Teh Manis', 'kategori' => 'Minuman', 'harga' => 15000, 'deskripsi' => 'Es teh manis segar.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}