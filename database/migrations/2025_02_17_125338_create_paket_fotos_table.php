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
        Schema::create('paket_fotos', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_paket_foto');
            $table->string('nama_paket_foto');
            $table->string('harga_paket_foto');
            $table->string('fasilitas');
            $table->string('gambar')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_fotos');
    }
};
