<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservasiiResource;
use App\Models\Reservasii;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class ReservasiTerbaru extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(ReservasiiResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                ->label('ID Reservasi')
                ->searchable(),
                TextColumn::make('user.name')
                ->label('Nama')
                ->searchable(),
                TextColumn::make('tanggal')
                ->label('Tanggal')
                ->sortable(),
                TextColumn::make('waktu')
                ->label('Jam'),
                TextColumn::make('tipe_pembayaran')
                ->label('Tipe Pembayaran')
                ->badge()
                ->color(fn (string $state): String => match ($state){
                    'full' => 'succes',
                    'DP' => 'danger'
                }),
                TextColumn::make('metode_pembayaran')
                ->label('Metode Pembayaran')
                ->badge(),
                TextColumn::make('created_at')
                ->label('Waktu Reservasi')
            ])
            ->actions([
                Action::make('Lihat Reservasi')
                ->url(fn (Reservasii $record): string => ReservasiiResource::getUrl('view', ['record' => $record]))
                ->icon('heroicon-m-eye')
            ]);
            
    }
}
