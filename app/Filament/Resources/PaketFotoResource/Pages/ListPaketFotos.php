<?php

namespace App\Filament\Resources\PaketFotoResource\Pages;

use App\Filament\Resources\PaketFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaketFotos extends ListRecords
{
    protected static string $resource = PaketFotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
