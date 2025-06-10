<?php

namespace App\Filament\Resources\ReservasiiResource\Pages;

use App\Filament\Resources\ReservasiiResource;
use App\Filament\Resources\ReservasiiResource\Widgets\ReservasiiStats;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Components\Tabs;
use Filament\Resources\Pages\ListRecords;

class ListReservasiis extends ListRecords
{
    protected static string $resource = ReservasiiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    //protected function getHeaderWidgets(): array{
       // return[
         //   ReservasiiStats::class
        //];
    //}

    public function getTabs(): array{
        $paketFotos = \App\Models\PaketFoto::orderBy('nama_paket_foto')->get();
        
        $tabs = [
            null => \Filament\Resources\Components\Tab::make('Semua Paket')
                ->badge(fn () => \App\Models\Reservasii::count())
                ->icon('heroicon-o-photo'),
        ];

        foreach ($paketFotos as $paketFoto) {
            $tabs[$paketFoto->id] = \Filament\Resources\Components\Tab::make($paketFoto->nama_paket_foto)
                ->query(fn($query) => $query->whereRelation('detail.paketFoto', 'nama_paket_foto', $paketFoto->nama_paket_foto))
                ->badge(fn () => \App\Models\Reservasii::whereRelation('detail.paketFoto', 'nama_paket_foto', $paketFoto->nama_paket_foto)->count())
                ->icon('heroicon-o-camera');
        }

        return $tabs;
    }
}
