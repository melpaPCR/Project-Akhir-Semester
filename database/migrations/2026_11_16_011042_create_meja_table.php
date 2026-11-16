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
        Schema::create('meja', function (Blueprint $table) {
        $table->id('id_meja');
        $table->string('nomor_meja'); // Contoh: Meja 02, Meja 04
        $table->integer('kapasitas'); // Contoh: 2, 4, 6 orang
        $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};
