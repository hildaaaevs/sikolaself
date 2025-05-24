<?php

namespace App\Filament\Resources\ReservasiiResource\Pages;

use App\Filament\Resources\ReservasiiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReservasii extends EditRecord
{
    protected static string $resource = ReservasiiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
