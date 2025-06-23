<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservasii;
use Carbon\Carbon;

class ReservasiRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservasi;

    public function __construct(Reservasii $reservasi)
    {
        $this->reservasi = $reservasi;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reservasi Anda Ditolak')
            ->greeting('Halo Sobat Minko!')
            ->line('Mohon maaf, reservasi Anda dengan nama : ' . $this->reservasi->nama . ' telah ditolak.')
            ->line('Tanggal : ' . Carbon::parse($this->reservasi->tanggal)->format('d F Y'))
            ->line('Waktu   : ' . $this->reservasi->waktu)
            ->line('Hal ini terjadi karena jadwal sudah penuh atau ada masalah dengan pembayaran.')
            ->line('Jika Anda merasa ini adalah sebuah kesalahan, silakan hubungi kami pada nomor dibawah ini.')
            ->line('WA : 082131919312')
            ->line('Terima kasih atas pengertian Anda.')
            ->salutation('Salam dari Minko');
    }
} 