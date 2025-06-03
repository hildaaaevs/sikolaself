<?php

namespace App\Livewire;

use App\Models\Reservasii;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Upload Bukti Pembayaran - SiKolaself')]
class UploadBuktiPembayaran extends Component
{
    use WithFileUploads;

    public $booking;
    public $bukti_pembayaran;
    public $bookingId;

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
    }

    public function uploadBuktiPembayaran()
    {
        $this->validate([
            'bukti_pembayaran' => 'required|image|max:2048', // max 2MB
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran harus diupload',
            'bukti_pembayaran.image' => 'File harus berupa gambar',
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