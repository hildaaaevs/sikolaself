<div class="w-full max-w-4xl py-6 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex items-center font-poppins">
        <div class="w-full px-4 py-4 mx-auto bg-white border rounded-lg shadow-sm">
            <div>
                <h1 class="mb-6 text-xl font-semibold text-gray-700">
                    Upload Bukti Pembayaran
                </h1>

                <!-- Informasi Pelanggan -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-medium">{{ $booking->nama }}</p>
                        </div>
                        @if($booking && $booking->user)
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $booking->user->email }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Booking -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600">Order Number</p>
                        <p class="font-medium">{{ $booking->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d-m-Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Waktu</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($booking->waktu)->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="font-medium text-blue-600">Rp {{ number_format($booking->total, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Detail Pembayaran -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h2 class="text-lg font-semibold mb-3">Detail Pembayaran</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Metode Pembayaran</p>
                            <p class="font-medium">{{ ucfirst($booking->metode_pembayaran) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tipe Pembayaran</p>
                            <p class="font-medium">{{ strtoupper($booking->tipe_pembayaran) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Harga</p>
                            <p class="font-medium">Rp {{ number_format($booking->total, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jumlah yang Harus Dibayar</p>
                            <p class="font-medium">
                                @if($booking->tipe_pembayaran === 'dp')
                                    Rp {{ number_format(max(20000, $booking->total * 0.3), 0, ',', '.') }}
                                    <span class="text-xs text-gray-500 block">(Minimal 30% atau Rp 20.000)</span>
                                @else
                                    Rp {{ number_format($booking->total, 0, ',', '.') }}
                                    <span class="text-xs text-gray-500 block">(Pembayaran Penuh)</span>
                                @endif
                            </p>
                        </div>
                        @if($booking->metode_pembayaran === 'transfer')
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-600">Nomor Rekening</p>
                                <p class="font-medium">1234567890 (Bank BCA)</p>
                                <p class="text-xs text-gray-500">a.n. Nama Studio Foto</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Form Upload -->
                <form wire:submit="uploadBuktiPembayaran">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                            <input type="file" wire:model="bukti_pembayaran" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('bukti_pembayaran')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-end space-x-4 pt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Upload Bukti Pembayaran
                            </button>
                            <a href="{{ route('histori') }}" class="px-4 py-2 text-blue-500 border border-blue-500 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>