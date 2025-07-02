<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ReservasiApproved;
use App\Notifications\ReservasiRejected;
use Illuminate\Support\Facades\Log;

class Reservasii extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'waktu',
        'promo_id',
        'total',
        'tipe_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran'
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

    protected static function booted()
    {
        static::updated(function ($reservasi) {
            // Cek apakah status pembayaran berubah
            if ($reservasi->isDirty('status_pembayaran')) {
                // Jika status menjadi 'approved'
                if ($reservasi->status_pembayaran === 'approved') {
                    // Kirim notifikasi 'approved' ke user
                    try {
                        $reservasi->user->notify(new ReservasiApproved($reservasi));
                        Log::info('Notifikasi email [approved] berhasil dikirim untuk reservasi ID: ' . $reservasi->id);
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim notifikasi email [approved]: ' . $e->getMessage());
                    }

                    // Otomatis reject reservasi lain yang bentrok
                    $paketFotoIds = $reservasi->detail()->pluck('paket_foto_id')->toArray();
                    $reservasiBentrok = self::where('id', '!=', $reservasi->id)
                        ->where('tanggal', $reservasi->tanggal)
                        ->where('waktu', $reservasi->waktu)
                        ->where('status_pembayaran', 'pending')
                        ->whereHas('detail', function($q) use ($paketFotoIds) {
                            $q->whereIn('paket_foto_id', $paketFotoIds);
                        })
                        ->get();
                    
                    foreach ($reservasiBentrok as $r) {
                        // Update ini akan memicu event 'updated' lagi untuk reservasi yang ditolak,
                        // sehingga notifikasi 'rejected' akan terkirim secara otomatis.
                        $r->update(['status_pembayaran' => 'rejected']);
                    }
                } 
                // Jika status menjadi 'rejected'
                elseif ($reservasi->status_pembayaran === 'rejected') {
                    // Kirim notifikasi 'rejected' ke user
                    try {
                        $reservasi->user->notify(new ReservasiRejected($reservasi));
                        Log::info('Notifikasi email [rejected] berhasil dikirim untuk reservasi ID: ' . $reservasi->id);
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim notifikasi email [rejected]: ' . $e->getMessage());
                    }
                }
            }
        });
    }
}
    

