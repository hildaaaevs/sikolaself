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
        Schema::create('reservasi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasii_id')->constrained('reservasiis')->cascadeOnDelete();
            $table->foreignId('paket_foto_id')->constrained('paket_fotos')->cascadeOnDelete();
            $table->string('warna');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga',10, 2)->nullable();
            $table->decimal('total_harga',10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_details');
    }
};
