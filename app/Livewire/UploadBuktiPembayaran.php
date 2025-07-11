<?php

namespace App\Livewire;

use App\Models\Reservasii;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Title('Upload Bukti Pembayaran - SiKolaself')]
class UploadBuktiPembayaran extends Component
{
    use WithFileUploads;

    public $booking;
    public $bukti_pembayaran;
    public $bookingId;
    public $timeLeft;
    public $isExpired = false;

    public function mount($id)
    {
        $this->bookingId = $id;
        $this->booking = Reservasii::with(['user', 'detail.paketFoto', 'promo'])
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$this->booking) {
            session()->flash('error', 'Data booking tidak ditemukan');
            return redirect()->route('histori');
        }

        if ($this->booking->status_pembayaran === 'approved') {
            return redirect()->route('booking.success', $this->booking->id);
        }

        // Check if booking is expired
        $createdAt = Carbon::parse($this->booking->created_at);
        $expiryTime = $createdAt->addMinutes(5);
        
        if (Carbon::now()->gt($expiryTime)) {
            // Update status pembayaran menjadi rejected
            $this->booking->update(['status_pembayaran' => 'rejected']);
            
            // Hapus reservasi ini dari daftar waktu yang tidak tersedia
            DB::table('unavailable_times')
                ->where('tanggal', $this->booking->tanggal)
                ->where('waktu', $this->booking->waktu)
                ->where('reservasii_id', $this->booking->id)
                ->delete();
            
            $this->isExpired = true;
            session()->flash('error', 'Waktu upload bukti pembayaran telah habis. Reservasi ditolak.');
            return redirect()->route('histori');
        }

        $this->timeLeft = Carbon::now()->diffInSeconds($expiryTime);
    }

    public function getTimeLeftProperty()
    {
        if ($this->isExpired) {
            return 0;
        }

        $createdAt = Carbon::parse($this->booking->created_at);
        $expiryTime = $createdAt->addMinutes(1);
        return max(0, Carbon::now()->diffInSeconds($expiryTime));
    }

    public function uploadBuktiPembayaran()
    {
        if (
            $this->isExpired
        ) {
            session()->flash('error', 'Waktu upload bukti pembayaran telah habis.');
            return redirect()->route('histori');
        }

        $this->validate([
            'bukti_pembayaran' => 'required|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB, hanya gambar tertentu
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran harus diupload',
            'bukti_pembayaran.mimes' => 'File harus berupa gambar dengan format JPG, JPEG, PNG, atau WEBP. Dokumen tidak diperbolehkan.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB',
        ]);

        $path = $this->bukti_pembayaran->store('bukti-pembayaran', 'public');
        
        $this->booking->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'pending'
        ]);

        session()->flash('message', 'Bukti pembayaran berhasil diupload. Silahkan tunggu konfirmasi dari admin.');
        return redirect()->route('histori');
    }

    public function render()
    {
        return view('livewire.upload-bukti-pembayaran');
    }
}