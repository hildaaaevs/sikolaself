<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
		Booking 
	</h1>
	<form wire:submit.prevent="placeOrder">
  <div class="grid grid-cols-12 gap-4">
		<div class="md:col-span-12 lg:col-span-8 col-span-12">
			<!-- Card -->
			<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
				<!-- Shipping Address -->
      <div class="mb-6">
          <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
              Formulir Reservasi
          </h2>
          <div class="mt-4">
              <label class="block text-gray-700 dark:text-white mb-1" for="nama">
                  Nama Lengkap
              </label>
              <input wire:model="nama" class="w-full rounded-lg border py-2 px-3 
              dark:bg-gray-700 dark:text-white dark:border-none @error('nama') border-red-500 @enderror " id="nama" type="text">
              @error('nama')
              <div class="text-red-500 text-sm">{{ $message }}</div>
              @enderror
          </div>
          
          <div class="mt-4">
              <label class="block text-gray-700 dark:text-white mb-1" for="tanggal">
                  Tanggal
              </label>
              <input wire:model="tanggal" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('tanggal') border-red-500 @enderror" id="tanggal" type="date" min="{{ date('Y-m-d') }}">
              @error('tanggal')
              <div class="text-red-500 text-sm">{{ $message }}</div>
              @enderror
            </div>
    
        <div class="mt-4">
            <label class="block text-gray-700 dark:text-white mb-1" for="waktu">
                Waktu
            </label>
            <select wire:model="waktu" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('waktu') border-red-500 @enderror" id="waktu">
                <option value="">Pilih waktu</option>
                @php
                    $timeLabels = collect(range(8, 20))->mapWithKeys(function ($hour) {
                        $formatted = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                        return [$formatted => $formatted];
                    })->toArray();
                @endphp
                @foreach($timeLabels as $time => $label)
                    @php
                        $isUnavailable = in_array($time, $this->unavailableTimes);
                        $isBooked = in_array($time, $this->bookedTimes);
                        $isPast = $this->tanggal == now()->format('Y-m-d') && $time <= now()->format('H:i');
                    @endphp
                    <option value="{{ $time }}" 
                        {{ $isUnavailable ? 'disabled' : '' }} 
                        class="{{ $isUnavailable ? 'text-gray-400 bg-gray-100' : '' }}"
                        style="{{ $isUnavailable ? 'background-color: #f3f4f6; color: #9ca3af;' : '' }}">
                        {{ $label }}
                        @if($isBooked)
                            (Sudah dipesan)
                        @elseif($isPast)
                            (Sudah lewat)
                        @endif
                    </option>
                @endforeach
            </select>
            @error('waktu')
              <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>
      <div class="mt-4">
            <label class="block text-gray-700 dark:text-white mb-1" for="warna">
                Background
            </label>
            <select wire:model="warna" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('warna') border-red-500 @enderror" id="warna">
                <option value="">Pilih warna</option>
                <option value="putih">White</option>
                <option value="abu">Grey</option>
                <option value="cream">Cream</option>
                <option value="spotlight">Spotlight</option>
            </select>
            @error('warna')
              <div class="text-red-500 text-sm">{{ $message }}</div>
              @enderror
        </div>
        
        <div class="mt-4">
            <label class="block text-gray-700 dark:text-white mb-1" for="promo">
                Kode Promo (jika ada)
            </label>
            <div class="flex gap-2">
                <input wire:model="promo" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('promo') border-red-500 @enderror" id="promo" type="text" placeholder="Masukkan kode promo">
                <button type="button" wire:click="applyPromo" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Terapkan</button>
            </div>
            @error('promo')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
            @if($promoApplied)
                <div class="text-green-500 text-sm mt-1">Promo berhasil diterapkan!</div>
            @endif
        </div>
    </div>

    <div class="mb-6">
        <!-- Tipe Pembayaran - Muncul ketika Transfer Bank dipilih -->
    </div>
    <div class="mb-6">
      <!-- Transfer Bank via Midtrans -->
      <div class="mt-6"> 
      </div>
    </div>
    </div>
          <!-- End Card -->
        </div>
        <div class="md:col-span-12 lg:col-span-4 col-span-12">
          <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
          <div class="mb-6">
      <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-4">
        Metode Pembayaran
      </h2>
      <!-- Pilih Tipe Pembayaran -->
      <div class="mt-4">
        <label class="block text-gray-700 dark:text-white mb-1">Tipe Pembayaran</label>
        <ul class="grid w-full gap-4 md:grid-cols-2">
          <li>
            <input wire:model="tipe_pembayaran" class="hidden peer" id="payment-dp" name="payment_type" type="radio" value="dp" required />
            <label for="payment-dp" class="inline-flex items-center justify-between w-full p-5 bg-white border border-gray-200 rounded-lg cursor-pointer 
            hover:bg-gray-100 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:text-blue-500 dark:border-gray-700 dark:hover:bg-gray-700">
              <div class="block">
                <div class="text-lg font-semibold">Down Payment</div>
                <div class="text-sm">Bayar DP terlebih dahulu</div>
              </div>
            </label>
          </li>
          <li>
            <input wire:model="tipe_pembayaran" class="hidden peer" id="payment-full" name="payment_type" type="radio" value="full" />
            <label for="payment-full" class="inline-flex items-center justify-between w-full p-5 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:text-blue-500 dark:border-gray-700 dark:hover:bg-gray-700">
              <div class="block">
                <div class="text-lg font-semibold">Full Payment</div>
                <div class="text-sm">Bayar lunas sekarang</div>
              </div>
            </label>
          </li>
          @error('tipe_pembayaran')
              <div class="text-red-500 text-sm">{{ $message }}</div>
          @enderror
        </ul>
      </div>

      <!-- Transfer Bank via Midtrans -->
      <div class="mt-6">
        <div class="grid grid-cols-2 gap-4">
        </div>
      </div>
    </div>

            <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                Rincian Reservasi
            </div>
            <div class="flex justify-between mb-2 font-bold">
              <span>
                Subtotal
              </span>
              <span>
                @if($paketfoto)
                  {{ Number::currency($paketfoto->harga_paket_foto, 'IDR') }}
                @else
                  {{ Number::currency(0, 'IDR') }}
                @endif
              </span>
            </div>
            @if($promoApplied)
            <div class="flex justify-between mb-2">
              <span>
                Potongan Promo
              </span>
              <span class="text-green-500">
                - {{ Number::currency($promoDiscount, 'IDR') }}
              </span>
            </div>
            @endif
            <hr class="bg-slate-400 my-4 h-1 rounded">
            <div class="flex justify-between mb-2 font-bold">
              <span>
                Grand Total
              </span>
              <span>
                {{ Number::currency($this->totalPrice, 'IDR') }}
              </span>
            </div>
            </hr>
          </div>
          <button type="submit" class="bg-gray-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-gray-600">
            Booking Sekarang
          </button>
          <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
              Paket Foto
            </div>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
              @if($paketfoto)
                <li class="py-3 sm:py-4" wire:key="{{ $paketfoto->id }}">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <img alt="{{ $paketfoto->nama_paket_foto }}" class="w-12 h-12 rounded-full" src="{{ url('storage', $paketfoto->gambar) }}"> </img>
                    </div>
                    <div class="flex-1 min-w-0 ms-4">
                      <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ $paketfoto->nama_paket_foto }}
                      </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                      {{ Number::currency($paketfoto->harga_paket_foto, 'IDR') }}
                    </div>
                  </div>
                </li>
              @else
                <li class="py-3 sm:py-4">
                  <div class="flex items-center justify-center">
                    <p class="text-sm text-gray-500">No package selected</p>
                  </div>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
  </form>
</div>