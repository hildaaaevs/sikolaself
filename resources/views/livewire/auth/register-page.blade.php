<div class="min-h-screen bg-gray-400 flex items-center justify-center px-4">
  <div class="bg-white rounded-lg shadow-lg flex flex-col lg:flex-row w-full max-w-4xl overflow-hidden">
    
    <!-- Logo Kiri -->
    <div class="flex items-center justify-center bg-gray-300 w-full md:w-1/2 p-6">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-64 h-64 object-cover rounded-full border-2 border-black shadow-md">
    </div>

    <!-- Form Kanan -->
    <div class="bg-white w-full md:w-1/2 flex items-center justify-center p-10">
      <main class="w-full max-w-md mx-auto">
        <div class="w-full border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Daftar</h1>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Sudah punya akun?
                <a wire:navigate class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/login">
                  Login
                </a>
              </p>
            </div>
            <hr class="my-5 border-slate-300">

            <!-- Form -->
            <form wire:submit.prevent="save">
              <div class="grid gap-y-4">

                <!-- Field Nama -->
                <div>
                  <label for="name" class="block text-sm mb-2 dark:text-white">Nama</label>
                  <div class="relative">
                    <input type="text" id="name" wire:model="name" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="email-error">
                    @error('name')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('name')
                  <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Field Email -->
                <div>
                  <label for="email" class="block text-sm mb-2 dark:text-white">Alamat Email</label>
                  <div class="relative">
                    <input type="email" id="email" wire:model="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="email-error">
                    @error('email')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('email')
                  <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Field Password -->
                <div>
                  <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                  <div class="relative">
                    <input type="password" id="password" wire:model="password" class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="password-error">
                    @error('password')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('password')
                  <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Tombol -->
                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  Daftar
                </button>
              </div>
            </form>
            <!-- End Form -->

          </div>
        </div>
      </main>
    </div>
  </div>
</div>
