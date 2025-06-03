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
                            Tambah
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