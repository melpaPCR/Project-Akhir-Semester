<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
protected $primaryKey = 'id_menu';
protected $fillable = ['nama_menu', 'kategori', 'harga', 'deskripsi', 'gambar'];

public function pesanan()
{
    return $this->hasMany(Pesanan::class, 'id_menu', 'id_menu');
}
}
