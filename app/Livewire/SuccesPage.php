<?php

namespace App\Livewire;

use App\Models\Reservasii;
use Livewire\Component;

class SuccesPage extends Component
{
    public $booking;
    public $bookingName;

    public function mount($id = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil booking berdasarkan ID jika ada, jika tidak ambil yang terakhir
        $this->booking = Reservasii::with(['user', 'detail.paketFoto'])
            ->where('user_id', auth()->id())
            ->when($id, function($query) use ($id) {
                return $query->where('id', $id);
            })
            ->latest()
            ->first();
            
        if (!$this->booking) {
            session()->flash('error', 'Tidak ada data booking yang ditemukan');
            return redirect()->route('home');
        }
            
        // Ambil nama dari session
        $this->bookingName = session('booking_name');
    }

    public function render()
    {
        return view('livewire.succes-page');
    }
}
