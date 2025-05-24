<x-filament::widget>
    <x-filament::card>
        <div x-data="calendarWidget()" x-init="init()" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kalender -->
            <div>
                <h3 class="text-lg font-bold mb-2">PILIH TANGGAL</h3>
                <input type="text" id="datepicker" class="w-full border px-4 py-2 rounded" placeholder="Pilih Tanggal" />
            </div>

            <!-- Daftar Jam -->
            <div>
                <h3 class="text-lg font-bold mb-2">JAM TERSEDIA</h3>
                <div class="grid grid-cols-3 gap-2">
                    <template x-for="jam in semuaWaktu" :key="jam">
                        <button 
                            class="px-2 py-1 rounded text-center"
                            :class="{
                                'bg-gray-300 text-white cursor-not-allowed': waktuTidakTersedia.includes(jam),
                                'bg-blue-500 text-white hover:bg-blue-600': !waktuTidakTersedia.includes(jam)
                            }"
                            x-text="jam"
                            :disabled="waktuTidakTersedia.includes(jam)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </x-filament::card>

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function calendarWidget() {
            return {
                selectedDate: null,
                allReservations: @json($this->getReservations()),
                waktuTidakTersedia: [],
                waktuTersedia: [],
                semuaWaktu: [
                    '08:00', '09:00', '10:00', '11:00', '12:00',
                    '13:00', '14:00', '15:00', '16:00', '17:00',
                    '18:00', '19:00', '20:00'
                ],

                init() {
                    flatpickr('#datepicker', {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        onChange: (selectedDates, dateStr) => {
                            this.selectedDate = dateStr;
                            this.updateTimes();
                        }
                    });
                },

                updateTimes() {
                    this.waktuTidakTersedia = this.allReservations[this.selectedDate] ?? [];
                    this.waktuTersedia = this.semuaWaktu.filter(w => !this.waktuTidakTersedia.includes(w));
                }
            }
        }
    </script>
    @endpush
</x-filament::widget>
