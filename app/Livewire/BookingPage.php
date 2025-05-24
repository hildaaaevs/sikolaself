<?php

namespace App\Livewire;

use App\Models\PaketFoto;
use App\Models\Reservasii;
use Livewire\Component;

class BookingPage extends Component
{
    public $paketfoto;
    public $nama = '';
    public $tanggal = '';
    public $waktu = '';
    public $warna = '';
    public $promo = '';
    public $tipe_pembayaran = '';
    public $bookedTimes = [];
    public $unavailableTimes = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->paketfoto = PaketFoto::findOrFail($id);
        } else {
            $this->paketfoto = PaketFoto::first();
        }
        
        // Set tanggal default ke hari ini
        $this->tanggal = now()->format('Y-m-d');
        $this->updateUnavailableTimes();
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

    public function placeOrder()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'warna' => 'required',
            'promo' => '',
            'tipe_pembayaran' => 'required',
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'nama.min' => 'Nama lengkap minimal 3 karakter',
            'tanggal.required' => 'Tanggal booking harus diisi',
            'tanggal.after_or_equal' => 'Tanggal booking tidak boleh sebelum hari ini',
            'waktu.required' => 'Waktu booking harus dipilih',
            'warna.required' => 'Background harus dipilih',
            'tipe_pembayaran.required' => 'Tipe pembayaran harus dipilih',
        ]);

        // Validasi waktu yang dipilih
        if (in_array($this->waktu, $this->unavailableTimes)) {
            $this->addError('waktu', 'Waktu yang dipilih tidak tersedia');
            return;
        }

        // Membuat reservasi baru
        $reservasi = Reservasii::create([
            'user_id' => auth()->id(),
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'promo_id' => null, // Logika promo bisa ditambahkan di sini
            'total' => $this->paketfoto->harga_paket_foto,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'metode_pembayaran' => 'transfer', // Default transfer, bisa diubah sesuai pilihan
        ]);

        // Membuat detail reservasi
        $reservasi->detail()->create([
            'paket_foto_id' => $this->paketfoto->id,
            'warna' => $this->warna,
            'jumlah' => 1,
            'harga' => $this->paketfoto->harga_paket_foto,
            'total_harga' => $this->paketfoto->harga_paket_foto,
        ]);

        // Tampilkan pesan sukses dan redirect
        session()->flash('message', 'Booking berhasil dibuat! Silahkan lakukan pembayaran sesuai metode yang dipilih.');
        session()->flash('booking_name', $this->nama);
        return redirect()->route('booking.success');
    }

    public function render()
    {
        // Update unavailable times setiap kali halaman di-render
        $this->updateUnavailableTimes();
        return view('livewire.booking-page');
    }
}
