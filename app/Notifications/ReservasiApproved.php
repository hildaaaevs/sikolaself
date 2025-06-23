<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservasii;
use Illuminate\Support\Facades\Log;

class ReservasiApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservasi;

    public function __construct(Reservasii $reservasi)
    {
        $this->reservasi = $reservasi;
        Log::info('Notifikasi ReservasiApproved dibuat untuk reservasi ID: ' . $reservasi->id);
    }

    public function via($notifiable)
    {
        Log::info('Mengirim notifikasi via email untuk reservasi ID: ' . $this->reservasi->id);
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Log::info('Menyiapkan email untuk reservasi ID: ' . $this->reservasi->id);
        return (new MailMessage)
            ->subject('Reservasi Anda Telah Disetujui')
            ->greeting('Halo Sobat Minko!')
            ->line('Reservasi Anda dengan nama  : ' . $this->reservasi->nama . ' telah disetujui.')
            ->line('Detail Reservasi')
            ->line('Tanggal             : ' . $this->reservasi->tanggal->format('d F Y'))
            ->line('Waktu               : ' . $this->reservasi->waktu)
            ->line('Total Pembayaran    : Rp ' . number_format($this->reservasi->total, 0, ',', '.'))
            ->line('Silahkan datang sesuai dengan jadwal yang telah ditentukan.')
            ->line('Terima kasih telah memilih layanan kami!')
            ->salutation('Salam dari Minko');
    }
} 