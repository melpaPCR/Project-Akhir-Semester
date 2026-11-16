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
        Schema::create('pesanan', function (Blueprint $table) {
        $table->id('id_pesanan');
        $table->foreignId('id_reservasi')->constrained('reservasi', 'id_reservasi')->onDelete('cascade');
        $table->foreignId('id_menu')->constrained('menu', 'id_menu')->onDelete('cascade');
        $table->integer('jumlah');
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
