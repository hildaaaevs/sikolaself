<div>
	<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
		<h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
			Reservasi 
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
									Nama
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
						<ul class="grid w-full gap-4 md:grid-cols-2">
							<li>
								<input wire:model="tipe_pembayaran" class="hidden peer" id="payment-dp" name="payment_type" type="radio" value="dp" required />
								<label for="payment-dp" class="inline-flex items-center justify-between w-full p-5 bg-white border border-gray-200 rounded-lg cursor-pointer 
								hover:bg-gray-100 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:text-blue-500 dark:border-gray-700 dark:hover:bg-gray-700">
									<div class="block">
										<div class="text-lg font-semibold">Down Payment</div>
										<div class="text-sm">DP min. Rp 20.000</div>
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
							{{ Number::currency(collect($selectedPakets)->sum('harga'), 'IDR') }}
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
							Total Harga
						</span>
						<span>
							{{ Number::currency($this->totalPrice, 'IDR') }}
						</span>
					</div>
					</hr>
				</div>
				<button type="submit" class="bg-gray-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-gray-600">
					Reservasi Sekarang
				</button>
				<div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
					<div class="flex justify-between items-center mb-4">
						<div class="text-xl font-bold underline text-gray-700 dark:text-white">
							Paket Foto
						</div>
						<button type="button" wire:click="$set('showModal', true)" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
							Tambah Paket
						</button>
					</div>
					<ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
						@forelse($selectedPakets as $index => $paket)
							<li class="py-3 sm:py-4" wire:key="{{ $paket['id'] }}">
								<div class="flex items-center">
									<div class="flex-shrink-0">
										<img alt="{{ $paket['nama'] }}" class="w-12 h-12 rounded-full" src="{{ url('storage', $paket['gambar']) }}">
									</div>
									<div class="flex-1 min-w-0 ms-4">
										<p class="text-sm font-medium text-gray-900 truncate dark:text-white">
											{{ $paket['nama'] }}
										</p>
									</div>
									<div class="flex items-center gap-4">
										<div class="text-base font-semibold text-gray-900 dark:text-white">
											{{ Number::currency($paket['harga'], 'IDR') }}
										</div>
										<button type="button" wire:click="removePaket({{ $index }})" class="text-red-500 hover:text-red-700">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
											</svg>
										</button>
									</div>
								</div>
							</li>
						@empty
							<li class="py-3 sm:py-4">
								<div class="flex items-center justify-center">
									<p class="text-sm text-gray-500">Belum ada paket dipilih</p>
								</div>
							</li>
						@endforelse
					</ul>
				</div>
			</div>
		</div>
	</form>
</div>

@if($showModal)
	<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
		<div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
			<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
			<span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
			<div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
				<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
					<div class="sm:flex sm:items-start">
						<div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
							<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
								Tambah Paket Foto
							</h3>
							<div class="mt-4">
								<input type="text" wire:model.live="search" placeholder="Cari paket foto..." class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
							</div>
							<div class="mt-4 max-h-96 overflow-y-auto">
								<ul class="divide-y divide-gray-200">
									@forelse($pakets as $paket)
										<li class="py-3">
											<div class="flex items-center justify-between">
												<div class="flex items-center">
													<img src="{{ url('storage', $paket->gambar) }}" alt="{{ $paket->nama_paket_foto }}" class="w-12 h-12 rounded-full">
													<div class="ml-4">
														<p class="text-sm font-medium text-gray-900">{{ $paket->nama_paket_foto }}</p>
														<p class="text-sm text-gray-500">{{ Number::currency($paket->harga_paket_foto, 'IDR') }}</p>
													</div>
												</div>
												<button wire:click="addPaket({{ $paket->id }})" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
													Pilih
												</button>
											</div>
										</li>
									@empty
										<li class="py-3 text-center text-gray-500">
											Tidak ada paket ditemukan
										</li>
									@endforelse
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
					<button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
						Tutup
					</button>
				</div>
			</div>
		</div>
	</div>
@endif