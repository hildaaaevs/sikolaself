<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservasii extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'waktu',
        'promo_id',
        'total',
        'tipe_pembayaran',
        'metode_pembayaran'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
        'total' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detail()
    {
    return $this->hasMany(ReservasiDetail::class);
    }
    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
    public function paketFoto()
    {
        return $this->belongsTo(PaketFoto::class);
    }
}
    

