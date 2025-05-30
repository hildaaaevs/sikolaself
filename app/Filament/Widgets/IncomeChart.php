<?php

namespace App\Filament\Widgets;

use App\Models\Reservasii;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class IncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pendapatan per Bulan';
    protected static ?int $sort = 2;
    protected string|array|int $columnSpan = 'full';
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $details = [];
        
        // Ambil data 12 bulan terakhir
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $total = Reservasii::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                ->sum('total');
            
            $count = Reservasii::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                ->count();
            
            $data[] = $total;
            $labels[] = $month->format('M Y');
            $details[] = [
                'total' => $total,
                'count' => $count,
                'month' => $month->format('F Y')
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data,
                    'backgroundColor' => '#6B7280',
                    'borderColor' => '#4B5563',
                    'details' => $details,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toLocaleString("id-ID"); }'
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'callbacks' => [
                        'title' => 'function(tooltipItems) {
                            const details = tooltipItems[0].dataset.details[tooltipItems[0].dataIndex];
                            return details.month;
                        }',
                        'label' => 'function(context) {
                            const details = context.dataset.details[context.dataIndex];
                            return [
                                "Total Pendapatan: Rp " + details.total.toLocaleString("id-ID"),
                                "Jumlah Reservasi: " + details.count
                            ];
                        }'
                    ],
                ],
            ],
        ];
    }
}