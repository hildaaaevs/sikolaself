<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use hasFactory;

    protected $fillable = [
        'kode',
        'tipe',
        'diskon',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
