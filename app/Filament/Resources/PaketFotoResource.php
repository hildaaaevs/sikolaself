<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaketFotoResource\Pages;
use App\Filament\Resources\PaketFotoResource\RelationManagers;
use App\Models\PaketFoto;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class PaketFotoResource extends Resource
{
    protected static ?string $model = PaketFoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('kode_paket_foto')
                            ->label('Kode Paket Foto')
                            ->maxLength(255),
                        TextInput::make('nama_paket_foto')
                            ->label('Nama Paket Foto')
                            ->maxLength(255),
                        TextInput::make('harga_paket_foto')
                            ->label('Harga')
                            ->maxLength(255),
                        MarkdownEditor::make('fasilitas')
                    ])->columnSpan(2),
                    Section::make()->schema([
                        FileUpload::make('gambar'),
                        Toggle::make('status')
                        ->required()
                        ->default(true),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_paket_foto'),
                TextColumn::make('nama_paket_foto'),
                TextColumn::make('harga_paket_foto')
                    ->label('Harga'),
                TextColumn::make('fasilitas'),
                ImageColumn::make('gambar')
                    ->label('Preview')
                    ->size(100), // Ukuran thumbnail
                IconColumn::make('status')
                    ->boolean()
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaketFotos::route('/'),
            'create' => Pages\CreatePaketFoto::route('/create'),
            'edit' => Pages\EditPaketFoto::route('/{record}/edit'),
        ];
    }
}
