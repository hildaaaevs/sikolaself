<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.calendar-widget';

    protected static ?string $heading = 'Jadwal Reservasi';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public function getReservations()
    {
        $data = DB::table('reservasiis')
            ->select('tanggal', 'waktu')
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->pluck('waktu')->toArray();
            });

        return $data;
    }
}
