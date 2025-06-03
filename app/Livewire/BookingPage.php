<?php

namespace App\Livewire;

use App\Models\PaketFoto;
use App\Models\Reservasii;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;

#[Title('Booking - SiKolaself')]
class BookingPage extends Component
{
    public $paketfoto;
    public $selectedPakets = [];
    public $showModal = false;
    public $search = '';
    public $pakets;
    public $nama = '';
    public $tanggal = '';
    public $waktu = '';
    public $warna = '';
    public $promo = '';
    public $tipe_pembayaran = '';
    public $bookedTimes = [];
    public $unavailableTimes = [];
    public $promoApplied = false;
    public $promoDiscount = 0;
    public $promoData = null;

    public function mount($id = null)
    {
        if ($id) {
            $this->paketfoto = PaketFoto::findOrFail($id);
            $this->selectedPakets[] = [
                'id' => $this->paketfoto->id,
                'nama' => $this->paketfoto->nama_paket_foto,
                'harga' => $this->paketfoto->harga_paket_foto,
                'gambar' => $this->paketfoto->gambar,
                'warna' => ''
            ];
        } else {
            $this->paketfoto = PaketFoto::first();
        }
        
        $this->tanggal = now()->format('Y-m-d');
        $this->updateUnavailableTimes();
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

    #[On('paket-added')]
    public function handlePaketAdded($paketId)
    {
        $paket = PaketFoto::find($paketId);
        if ($paket) {
            // Cek apakah paket sudah ada di selectedPakets
            $exists = collect($this->selectedPakets)->contains('id', $paket->id);
            if (!$exists) {
                $this->selectedPakets[] = [
                    'id' => $paket->id,
                    'nama' => $paket->nama_paket_foto,
                    'harga' => $paket->harga_paket_foto,
                    'gambar' => $paket->gambar,
                    'warna' => ''
                ];
            }
        }
    }

    public function addPaket($paketId)
    {
        $paket = PaketFoto::find($paketId);
        if ($paket) {
            // Cek apakah paket sudah ada di selectedPakets
            $exists = collect($this->selectedPakets)->contains('id', $paket->id);
            if (!$exists) {
                $this->selectedPakets[] = [
                    'id' => $paket->id,
                    'nama' => $paket->nama_paket_foto,
                    'harga' => $paket->harga_paket_foto,
                    'gambar' => $paket->gambar,
                    'warna' => ''
                ];
            }
        }
        $this->showModal = false;
    }

    public function removePaket($index)
    {
        unset($this->selectedPakets[$index]);
        $this->selectedPakets = array_values($this->selectedPakets);
    }

    public function updatePaketWarna($index, $warna)
    {
        $this->selectedPakets[$index]['warna'] = $warna;
    }

    public function updatedTanggal()
    {
        $this->waktu = ''; // Reset waktu yang dipilih
        $this->updateUnavailableTimes();
    }

    public function updateUnavailableTimes()
    {
        if ($this->tanggal) {
            // Ambil waktu yang sudah dipesan dari database untuk tanggal yang dipilih
            // dan paket foto yang sama
            $this->bookedTimes = Reservasii::where('tanggal', $this->tanggal)
                ->whereHas('detail', function($query) {
                    $query->where('paket_foto_id', $this->paketfoto->id);
                })
                ->pluck('waktu')
                ->map(function($time) {
                    return $time->format('H:i');
                })
                ->toArray();

            // Daftar semua waktu yang tersedia dari jam 8 pagi sampai 8 malam
            $allTimes = collect(range(8, 20))->map(function($hour) {
                return str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
            })->toArray();

            // Jika hari ini, tambahkan waktu yang sudah lewat
            if ($this->tanggal == now()->format('Y-m-d')) {
                $currentTime = now()->format('H:i');
                $pastTimes = array_filter($allTimes, function($time) use ($currentTime) {
                    return $time <= $currentTime;
                });
                $this->unavailableTimes = array_merge($this->bookedTimes, $pastTimes);
            } else {
                $this->unavailableTimes = $this->bookedTimes;
            }
        }
    }

    public function getUnavailableTimesProperty()
    {
        return $this->unavailableTimes;
    }

    public function getBookedTimesProperty()
    {
        return $this->bookedTimes;
    }

    public function applyPromo()
    {
        $this->promoApplied = false;
        $this->promoDiscount = 0;
        $this->promoData = null;

        if (empty($this->promo)) {
            return;
        }

        $promo = \App\Models\Promo::where('kode', $this->promo)
            ->where('aktif', true)
            ->first();

        if (!$promo) {
            $this->addError('promo', 'Kode promo tidak valid');
            return;
        }

        $this->promoData = $promo;
        $this->promoApplied = true;

        // Hitung diskon berdasarkan tipe promo
        if ($promo->tipe === 'fix') {
            $this->promoDiscount = $promo->diskon;
        } else if ($promo->tipe === 'persen') {
            $this->promoDiscount = ($this->paketfoto->harga_paket_foto * $promo->diskon) / 100;
        }
    }

    public function getTotalPriceProperty()
    {
        $total = collect($this->selectedPakets)->sum('harga');
        if ($this->promoApplied) {
            $total -= $this->promoDiscount;
        }
        return max(0, $total);
    }

    public function placeOrder()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'warna' => 'required',
            'promo' => '',
            'tipe_pembayaran' => 'required',
            'selectedPakets' => 'required|array|min:1',
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'nama.min' => 'Nama lengkap minimal 3 karakter',
            'tanggal.required' => 'Tanggal booking harus diisi',
            'tanggal.after_or_equal' => 'Tanggal booking tidak boleh sebelum hari ini',
            'waktu.required' => 'Waktu booking harus dipilih',
            'warna.required' => 'Background harus dipilih',
            'tipe_pembayaran.required' => 'Tipe pembayaran harus dipilih',
            'selectedPakets.required' => 'Pilih minimal satu paket foto',
            'selectedPakets.min' => 'Pilih minimal satu paket foto',
        ]);

        if (in_array($this->waktu, $this->unavailableTimes)) {
            $this->addError('waktu', 'Waktu yang dipilih tidak tersedia');
            return;
        }

        $reservasi = Reservasii::create([
            'user_id' => auth()->id(),
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'promo_id' => $this->promoData ? $this->promoData->id : null,
            'total' => $this->totalPrice,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'metode_pembayaran' => 'transfer',
            'status_pembayaran' => 'pending'
        ]);

        foreach ($this->selectedPakets as $paket) {
            $reservasi->detail()->create([
                'paket_foto_id' => $paket['id'],
                'warna' => $this->warna,
                'jumlah' => 1,
                'harga' => $paket['harga'],
                'total_harga' => $paket['harga'],
            ]);
        }

        session()->flash('message', 'Booking berhasil dibuat! Silahkan upload bukti pembayaran.');
        return redirect()->route('upload.bukti.pembayaran', $reservasi->id);
    }

    public function render()
    {
        // Update unavailable times setiap kali halaman di-render
        $this->updateUnavailableTimes();
        return view('livewire.booking-page');
    }
}
