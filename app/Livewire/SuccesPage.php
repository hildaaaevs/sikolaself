<?php

namespace App\Livewire;

use App\Models\Reservasii;
use Livewire\Component;

class SuccesPage extends Component
{
    public $booking;
    public $bookingName;

    public function mount()
    {
        // Ambil booking terakhir dari user yang sedang login
        $this->booking = Reservasii::with(['user', 'detail.paketFoto'])
            ->where('user_id', auth()->id())
            ->latest()
            ->first();
            
        // Ambil nama dari session
        $this->bookingName = session('booking_name');
    }

    public function render()
    {
        return view('livewire.succes-page');
    }
}
