<?php

namespace App\Livewire;

use App\Models\PaketFoto;
use Livewire\Component;

class AddPaketModal extends Component
{
    public $search = '';
    public $pakets;

    public function mount()
    {
        $this->loadPakets();
    }

    public function loadPakets()
    {
        $this->pakets = PaketFoto::where('nama_paket_foto', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedSearch()
    {
        $this->loadPakets();
    }

    public function addPaket($paketId)
    {
        $this->dispatch('paket-added', paketId: $paketId);
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.add-paket-modal');
    }
} 