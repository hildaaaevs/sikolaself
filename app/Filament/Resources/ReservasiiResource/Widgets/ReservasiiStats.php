<?php

namespace App\Filament\Resources\ReservasiiResource\Widgets;

use App\Models\Reservasii;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ReservasiiStats extends BaseWidget
{
    protected function getStats(): array{
        $todayEarnings = Reservasii::query()
            ->whereDate('tanggal', Carbon::today())
            ->sum('total');
            $mounthEarnings = Reservasii::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        return [
            Stat::make('Reservasi Hari Ini', Reservasii::query()->whereDate('tanggal', Carbon::today())->count()),
            Stat::make('Pendapatan Hari Ini', 'Rp' . number_format($todayEarnings, 0, ',', '.')),
            Stat::make('Pendapatan Per Bulan','Rp' . number_format($mounthEarnings, 0,',', '.'))
                    
                  ];
    
    }
}
