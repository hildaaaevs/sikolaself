<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <section class="overflow-hidden bg-white py-6 sm:py-11 font-poppins dark:bg-gray-800">
    <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
      <div class="flex flex-col md:flex-row -mx-4">
        <!-- Bagian Gambar -->
        <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="{ mainImage: '{{ url('storage', $paketfoto->gambar) }}' }">
          <div class="sticky top-0 z-50 overflow-hidden">
            <div class="aspect-[4/3]">
              <img x-bind:src="mainImage" alt="{{ $paketfoto->nama_paket_foto }}" class="object-cover w-full h-full rounded-lg shadow-lg">
            </div>
            <div class="flex-wrap hidden md:flex mt-4">
              <div class="w-1/2 p-2 sm:w-1/4" x-on:click="mainImage='https://m.media-amazon.com/images/I/71f5Eu5lJSL._SX679_.jpg'">
                {{-- <img src="https://m.media-amazon.com/images/I/71f5Eu5lJSL._SX679_.jpg" alt="Thumbnail" class="object-cover w-full h-20 rounded cursor-pointer hover:border-2 hover:border-blue-500">--}}
              </div>
            </div>
          </div>
        </div>

        <!-- Bagian Informasi -->
        <div class="w-full px-4 md:w-1/2">
          <div class="lg:pl-20">
            <div class="mb-8">
              <h2 class="max-w-xl mb-4 text-xl sm:text-2xl md:text-4xl font-bold dark:text-gray-400">
                {{ $paketfoto->nama_paket_foto }}
              </h2>
              <p class="inline-block mb-6 text-2xl sm:text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-400">
                <span>{{ Number::currency($paketfoto->harga_paket_foto, 'IDR') }}</span>
              </p>
              <p class="max-w-md text-sm sm:text-base text-gray-700 dark:text-gray-400">
                {{ $paketfoto->fasilitas }}
              </p>
            </div>
            <div class="w-full sm:w-32 mb-8">
              <div class="flex flex-col items-start">
                <a href="{{ route('booking', ['id' => $paketfoto->id]) }}" 
                   class="w-full sm:w-auto px-6 py-3 text-center bg-blue-500 rounded-md text-white hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700 transition duration-300">
                  Reservasi
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>