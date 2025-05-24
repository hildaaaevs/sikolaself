<?php

namespace App\Filament\Resources\ReservasiiResource\Pages;

use App\Filament\Resources\ReservasiiResource;
use App\Filament\Resources\ReservasiiResource\Widgets\ReservasiiStats;
use Filament\Actions;
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

    protected function getHeaderWidgets(): array{
        return[
            ReservasiiStats::class
        ];
    }
}
