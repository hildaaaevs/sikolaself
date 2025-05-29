<?php

namespace App\Livewire;

use App\Models\PaketFoto;
use BladeUI\Icons\Components\Icon;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Home Page - SiKolaself')]
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
 