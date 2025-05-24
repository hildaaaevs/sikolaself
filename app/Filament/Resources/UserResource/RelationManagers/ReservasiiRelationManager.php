<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\ReservasiiResource;
use Filament\Tables\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Reservasii;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservasiiRelationManager extends RelationManager
{
    protected static string $relationship = 'reservasii';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                ->label('ID Reservasi')
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
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Action::make('Lihat Reservasi')
                ->url(fn (Reservasii $record):string => ReservasiiResource::getUrl('view', ['record' => $record]))
                ->color('info')
                ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
