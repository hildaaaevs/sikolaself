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
                'nama_paket_foto' => 'Self Basic',
                'harga_paket_foto' => '75000',
                'fasilitas' => '1. Harga 2 orang, lebih dari 2 orang dikenakan biaya tambahan 25k 2. Foto sepuasanya 20 menit, bebas jepret sebanyaknya 3. Print 1x Single Frame',
                'gambar' => 'self_basic.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 102,
                'nama_paket_foto' => 'Basic Group',
                'harga_paket_foto' => '150000',
                'fasilitas' => '1. Lebih dari 5 orang dikenakan biaya 25k/orang 2. Foto 25 menit bebas jepret sebanyaknya 3. Print 5x Single Frame',
                'gambar' => 'basic_group.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 103,
                'nama_paket_foto' => 'Widebox',
                'harga_paket_foto' => '50000',
                'fasilitas' => '1. Maksimal 2 orang, lebih dari 2 orang dikenakan biaya tambahan 2. Foto 10 menit, bebas jepret sebanyaknya 3. Print 1x foto 4R',
                'gambar' => 'pasangan.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 104,
                'nama_paket_foto' => 'Widebox Group',
                'harga_paket_foto' => '125000',
                'fasilitas' => '1. Maksimal 6 orang dalam 1 sesi 2. Foto 15 menit, bebas jepret sebanyaknya 3. Print 4x Single Frame 4R',
                'gambar' => 'widebox_group.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 105,
                'nama_paket_foto' => 'Self Neo',
                'harga_paket_foto' => '75000',
                'fasilitas' => '1. Konsep self studio ala di rumah biru yang harga bikin fotomu otentik dan lucu 2. Harga untuk 2 orang',
                'gambar' => 'self_neo.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 106,
                'nama_paket_foto' => 'Foto w/ Anabul',
                'harga_paket_foto' => '15000',
                'fasilitas' => '1. Bebas hewan apa saja, asal tidak membahayakan 2. Popok hewan disarankan',
                'gambar' => 'foto_anabul.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 107,
                'nama_paket_foto' => 'Tambah Orang',
                'harga_paket_foto' => '25000',
                'fasilitas' => '1. Berlaku untuk semua paket jika menambah orang 2. Print 1x single frame 4R',
                'gambar' => 'tambah_orang.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 108,
                'nama_paket_foto' => 'Tambah Waktu',
                'harga_paket_foto' => '10000',
                'fasilitas' => '1. Dihitung per 5 menit 2. Bebas menambah waktu hingga 20 menit',
                'gambar' => 'tambah_waktu.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_paket_foto' => 109,
                'nama_paket_foto' => 'Semua File Foto',
                'harga_paket_foto' => '10000',
                'fasilitas' => '1. Dapat semua foto 2. Disarankan bawa flashdisk 3. Bisa kirim via Google Drive(masa aktif 4 hari) 4. Bisa kirim via Airdrop (IOS)',
                'gambar' => 'semua_file_foto.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
