<?php

namespace App\Livewire;

use App\Models\Reservasii;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Histori - Sikolasef')]
class Histori extends Component
{
    public function render()
    {
        $bookings = Reservasii::with(['detail.paketFoto'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.histori', [
            'bookings' => $bookings
        ]);
    }
}
