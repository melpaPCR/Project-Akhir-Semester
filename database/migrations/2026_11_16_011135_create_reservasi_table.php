<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
        $table->id('id_reservasi');
        $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
        $table->foreignId('id_meja')->constrained('meja', 'id_meja')->onDelete('cascade');
        $table->date('tanggal_reservasi');
        $table->time('waktu_reservasi');
        $table->integer('jumlah_tamu');
        $table->string('bukti_pembayaran')->nullable(); // Mendukung fitur pembayaran & konfirmasi admin
        $table->enum('status_reservasi', [
            'menunggu_pembayaran',
            'menunggu_konfirmasi',
            'dikonfirmasi',
            'selesai',
            'dibatalkan'
    ])->default('menunggu_pembayaran');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
