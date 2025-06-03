<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\PaketFoto;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Paket Foto - Sikolaself')]
class PaketFotoPage extends Component
{
    use WithPagination;

    #[Url]
    public $sort = 'latest';

    // tambah
    //public function addToCart($paketfoto_id){
      //  $total_count = CartManagement::addItemToCart($paketfoto_id); 

        //$this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class); 
    //}

    public function render()
    {
        $paketfoto = PaketFoto::when($this->sort === 'price', function($query) {
            return $query->orderBy('harga_paket_foto', 'asc');
        })
        ->when($this->sort === 'latest', function($query) {
            return $query->latest();
        })
        ->paginate(6);

        return view('livewire.paket-foto-page', [
            'paketfoto' => $paketfoto
        ]);
    }
}
