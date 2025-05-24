<?php

namespace App\Livewire;

use App\Models\PaketFoto;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Tittle('Home Page - SiKolaself')]
class HomePage extends Component
{
    public function render()
    {  
        $paketfoto = PaketFoto::where('status', 1)->get();
        return view('livewire.home-page', [
            'paketfoto' => $paketfoto
        ]);
    }
}
 