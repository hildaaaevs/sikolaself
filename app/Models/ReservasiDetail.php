<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiDetail extends Model
{
    use HasFactory;

    protected $table = 'reservasi_details';

    protected $fillable = [
        'reservasii_id',
        'paket_foto_id',
        'warna',
        'jumlah',
        'harga',
        'total_harga',
    ];

    public function reservasii()
    {
        return $this->belongsTo(Reservasii::class, 'reservasii_id');
    }

    public function paketFoto()
    {
        return $this->belongsTo(PaketFoto::class, 'paket_foto_id');
    }
}
