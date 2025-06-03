<section class="flex items-center font-poppins dark:bg-gray-800 ">
  <div class="justify-center flex-1 max-w-6xl px-4 py-4 mx-auto bg-white border rounded-md dark:border-gray-900 dark:bg-gray-900 md:py-10 md:px-10">
    <div>
      <h1 class="px-4 mb-8 text-2xl font-semibold tracking-wide text-gray-700 dark:text-gray-300 ">
        @if($booking->status_pembayaran === 'approved')
          Terimakasih. Reservasi Berhasil.
        @elseif($booking->status_pembayaran === 'pending')
          Menunggu Konfirmasi Pembayaran.
        @elseif($booking->status_pembayaran === 'rejected')
          Reservasi Ditolak.
        @endif
      </h1>
      <div class="flex border-b border-gray-200 dark:border-gray-700  items-stretch justify-start w-full h-full px-4 mb-8 md:flex-row xl:flex-col md:space-x-6 lg:space-x-8 xl:space-x-0">
        <div class="flex items-start justify-start flex-shrink-0">
          <div class="flex items-center justify-center w-full pb-6 space-x-4 md:justify-start">
            <div class="flex flex-col items-start justify-start space-y-2">
              <p class="text-lg font-semibold leading-4 text-left text-gray-800 dark:text-gray-400">
                {{ $bookingName }}</p>
              @if($booking && $booking->user)
              <p class="text-sm leading-4 text-gray-600 dark:text-gray-400">{{ $booking->user->email }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap items-center pb-4 mb-10 border-b border-gray-200 dark:border-gray-700">
        <div class="w-full px-4 mb-4 md:w-1/5">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
            Order Number: </p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
            {{ $booking->id }}</p>
        </div>
        <div class="w-full px-4 mb-4 md:w-1/5">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
            Tanggal: </p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
            {{ \Carbon\Carbon::parse($booking->tanggal)->format('d-m-Y') }}</p>
        </div>
        <div class="w-full px-4 mb-4 md:w-1/5">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
            Waktu: </p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
            {{ \Carbon\Carbon::parse($booking->waktu)->format('H:i') }}</p>
        </div>
        <div class="w-full px-4 mb-4 md:w-1/5">
          <p class="mb-2 text-sm font-medium leading-5 text-gray-800 dark:text-gray-400 ">
            Total: </p>
          <p class="text-base font-semibold leading-4 text-blue-600 dark:text-gray-400">
            Rp {{ number_format($booking->total, 0, ',', '.') }}</p>
        </div>
        <div class="w-full px-4 mb-4 md:w-1/5">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
            Payment Method: </p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400 ">
            {{ ucfirst($booking->metode_pembayaran) }} </p>
        </div>
      </div>
      <div class="px-4 mb-10">
        <div class="flex flex-col items-stretch justify-center w-full space-y-4 md:flex-row md:space-y-0 md:space-x-8">
          <div class="flex flex-col w-full space-y-6 ">
            <h2 class="mb-2 text-xl font-semibold text-gray-700 dark:text-gray-400">Detail Reservasi</h2>
            <div class="flex flex-col items-center justify-center w-full pb-4 space-y-4 border-b border-gray-200 dark:border-gray-700">
              @foreach($booking->detail as $detail)
              <div class="flex justify-between w-full">
                <p class="text-base leading-4 text-gray-800 dark:text-gray-400">{{ $detail->paketFoto->nama_paket_foto }}</p>
                <p class="text-base leading-4 text-gray-600 dark:text-gray-400">Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
              </div>
              <div class="flex justify-between w-full">
                <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Background: {{ ucfirst($detail->warna) }}</p>
              </div>
              @endforeach
            </div>
            @if($booking->promo)
            <div class="flex items-center justify-between w-full">
              <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Promo: {{ $booking->promo->kode }}</p>
              <p class="text-base leading-4 text-green-600 dark:text-green-400">- Rp {{ number_format($booking->detail->sum('harga') - $booking->total, 0, ',', '.') }}</p>
            </div>
            @endif
            <div class="flex items-center justify-between w-full">
              <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">Total</p>
              <p class="text-base font-semibold leading-4 text-gray-600 dark:text-gray-400">Rp {{ number_format($booking->total, 0, ',', '.') }}</p>
            </div>
          </div>
        </div>
      </div>

      @if($booking->bukti_pembayaran)
      <div class="mt-8 px-4">
        <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-400">Bukti Pembayaran</h2>
        <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="max-w-md rounded-lg shadow-lg">
      </div>
      @endif

      <div class="flex items-center justify-start gap-4 px-4 mt-6 ">
        <a href="/paketfoto" class="w-full text-center px-4 py-2 text-blue-500 border border-blue-500 rounded-md md:w-auto hover:text-white hover:bg-blue-600 dark:border-gray-700 dark:hover:bg-gray-700 dark:text-gray-300">
          Kembali
        </a>
        <a href="/histori" class="w-full text-center px-4 py-2 bg-blue-500 rounded-md text-gray-50 md:w-auto dark:text-gray-300 hover:bg-blue-600 dark:hover:bg-gray-700 dark:bg-gray-800">
          Lihat Histori
        </a>
      </div>
    </div>
  </div>
</section>