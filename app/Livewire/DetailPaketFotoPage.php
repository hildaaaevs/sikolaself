<?php

namespace App\Livewire;

use App\Models\PaketFoto;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Sikolasef - Detail Paket Foto')]
class DetailPaketFotoPage extends Component
{
    public $nama_paket_foto;

    public function mount($nama_paket_foto) {
        $this->nama_paket_foto = $nama_paket_foto;
    }

    public function addToCart($paketfoto_id) {
        $total_count = CartManagement::addItemToCart($paketfoto_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
    }

    public function render()
    {
        return view('livewire.detail-paket-foto-page', [
            'paketfoto' => PaketFoto::where('nama_paket_foto', $this->nama_paket_foto)->firstOrFail(),
        ]);
    }
}
