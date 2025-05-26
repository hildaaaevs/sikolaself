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
        return[
            null => \Filament\Resources\Components\Tab::make('Semua'),
            'Paket Pasangan' => \Filament\Resources\Components\Tab::make()->query(fn($query) => $query->whereRelation('detail.paketFoto', 'nama_paket_foto', 'Paket Pasangan')),
            'Paket 5 orang' => \Filament\Resources\Components\Tab::make()->query(fn($query) => $query->whereRelation('detail.paketFoto', 'nama_paket_foto', 'Paket 5 Orang')),
            'Widebox Couple' => \Filament\Resources\Components\Tab::make()->query(fn($query) => $query->whereRelation('detail.paketFoto', 'nama_paket_foto', 'Widebox Couple')),
            'Widebox Group' => \Filament\Resources\Components\Tab::make()->query(fn($query) => $query->whereRelation('detail.paketFoto', 'nama_paket_foto', 'Widebox Group')),
        ];
    }
}
