<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';
protected $primaryKey = 'id_reservasi';
protected $fillable = [
    'id_user', 'id_meja', 'tanggal_reservasi', 'waktu_reservasi',
    'jumlah_tamu', 'bukti_pembayaran', 'status_reservasi'
];

public function user() { return $this->belongsTo(User::class, 'id_user', 'id_user'); }
public function meja() { return $this->belongsTo(Meja::class, 'id_meja', 'id_meja'); }
public function pesanan() { return $this->hasMany(Pesanan::class, 'id_reservasi', 'id_reservasi'); }
}
