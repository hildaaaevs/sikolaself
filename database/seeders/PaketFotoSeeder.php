<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PaketFotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paket_fotos')->insert([
            [
                'kode_paket_foto' => 101,
                'nama_paket_foto' => 'Paket Pasangan',
                'harga_paket_foto' => '75000',
                'fasilitas' => '20 menit foto, 1x cetak foto single frame',
                'gambar' => '01JMC5FASB77HCJQHGNNS56X3P.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_paket_foto' => 102,
                'nama_paket_foto' => 'Paket 5 Orang',
                'harga_paket_foto' => '150000',
                'fasilitas' => '25 menit foto, 5x cetak foto single frame',
                'gambar' => 'gold.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_paket_foto' => 103,
                'nama_paket_foto' => 'Widebox Couple',
                'harga_paket_foto' => '50000',
                'fasilitas' => '10 menit foto, 1x cetak foto 4R',
                'gambar' => 'platinum.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode_paket_foto' => 103,
                'nama_paket_foto' => 'Widebox Group',
                'harga_paket_foto' => '110000',
                'fasilitas' => '10 menit foto, 5x cetak foto 4R',
                'gambar' => 'platinum.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
