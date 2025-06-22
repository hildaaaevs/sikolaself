<div class="min-h-screen bg-gray-400 flex items-center justify-center px-4">
  <div class="bg-white rounded-lg shadow-lg flex flex-col lg:flex-row w-full max-w-4xl overflow-hidden">
    
    <!-- Left Side - Logo -->
    <div class="bg-gray-200 flex items-center justify-center lg:w-1/2 p-6">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-72 h-72 sm:w-40 sm:h-40 lg:w-56 lg:h-56 object-cover rounded-full border-2 border-gray-400 shadow-md">
    </div>
    
    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 p-6 sm:p-10">
    <div class="w-full border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="p-4 sm:p-7">
      <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>
      <form wire:submit.prevent="save" class="space-y-6">

        @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg text-sm mb-4" role="alert">
          {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg text-sm mb-4" role="alert">
          {{ session('error') }}
        </div>
        @endif

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Alamat Email</label>
          <input type="email" id="email" wire:model="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
          @error('email')
          <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <div class="flex justify-between items-center mb-1">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
            <a href="/forgot" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
          </div>
          <input type="password" id="password" wire:model="password" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
          @error('password')
          <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 px-4 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700">Login</button>

        <p class="text-sm text-center text-gray-600">Belum punya akun? <a href="/register" class="text-blue-600 hover:underline">Daftar</a></p>
      </form>
  </div>
</div>
