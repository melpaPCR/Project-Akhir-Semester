<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
protected $primaryKey = 'id_pesanan';
protected $fillable = ['id_reservasi', 'id_menu', 'jumlah', 'subtotal'];

public function reservasi() { return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi'); }
public function menu() { return $this->belongsTo(Menu::class, 'id_menu', 'id_menu'); }
}
