<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservasiiResource\Pages;
use App\Filament\Resources\ReservasiiResource\RelationManagers;
use Filament\Tables\Actions\ActionGroup;
use App\Models\PaketFoto;
use App\Models\Reservasii;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\NumericInput;
use Filament\Forms\Set;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\BelongsToSelect;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Modal;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class ReservasiiResource extends Resource
{
    protected static ?string $model = Reservasii::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationLabel = 'Reservasi';
    public static function getPluralLabel(): string{
        return 'Reservasi';}
        public static function getModelLabel(): string
{
    return 'Reservasi';
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2) ->schema([
                    Group::make()->schema([
                        Section::make('Informasi Reservasi')->schema([
                            Select::make('user_id')
                                ->label('Nama')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('nama')
                                ->label('Nama')
                                ->required(),
                            Select::make('metode_pembayaran')
                                ->label('Metode pembayaran')
                                ->options([
                                    'tunai' => 'Tunai',
                                    'transfer' => 'Transfer Bank',
                                ])
                                ->required(),
                            Radio::make('tipe_pembayaran')
                                ->label('Tipe pembayaran')
                                ->options([
                                    'full' => 'Full',
                                    'dp' => 'DP',
                                ])
                                ->required()
                                ->default('full')
                                ->inline(),
                            Select::make('status_pembayaran')
                                ->label('Status Pembayaran')
                                ->options([
                                    'pending' => 'Pending',
                                    'approved' => 'Approved',
                                    'rejected' => 'Rejected',
                                ])
                                ->required()
                                ->default('pending'),
                            FileUpload::make('bukti_pembayaran')
                                ->label('Bukti Pembayaran')
                                ->image()
                                ->directory('bukti-pembayaran')
                                ->visibility('public')
                                ->preserveFilenames()
                                ->downloadable()
                                ->openable()
                                ->deleteUploadedFileUsing(function ($file) {
                                    Storage::disk('public')->delete($file);
                                })
                                ->columnSpanFull(),
                        ])
                    ])->columnSpan(1),
                     
                    Group::make()->schema([
                        Section::make('Promo')->schema([
                            Select::make('promo_id')
                                ->label('Promo')
                                ->relationship('promo', 'kode')
                                ->searchable()
                                ->preload()
                                ->nullable()
                                ->options(function() {
                                    return \App\Models\Promo::where('aktif', true)
                                        ->pluck('kode', 'id');
                                }),
                        ]),

                        Section::make('Jadwal Reservasi')->schema([
                            DatePicker::make('tanggal')
                                ->label('Tanggal')
                                ->required(),
                            Select::make('waktu')
                                ->label('Pilih Jam')
                                ->options(
                                    collect(range(8, 23))->mapWithKeys(function ($hour) {
                                        $formatted = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                                        return [$formatted => $formatted];
                                    })->toArray()
                                )
                                ->required()
                                ->disabled()
                                ->dehydrated()
                                ->default(fn ($record) => $record?->waktu),
                        ]),
                    ])->columnSpan(1),


                    Section::make('Detail Reservasi')->schema([
                        Repeater::make('detail')
                            ->relationship()
                            ->schema([
                                Grid::make(12) 
                                    ->schema([
                                        Select::make('paket_foto_id')
                                            ->relationship('paketFoto', 'nama_paket_foto')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->distinct()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->columnSpan(3)
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Set $set) => $set('harga', PaketFoto::find
                                            ($state)?->harga_paket_foto ?? 0))
                                            ->afterStateUpdated(fn ($state, Set $set) => $set('total_harga', PaketFoto::find
                                            ($state)?->harga_paket_foto ?? 0)), 

                                        Select::make('warna')
                                            ->label('Background')
                                            ->required()
                                            ->options([
                                                'putih' => 'White',
                                                'abu' => 'Grey',
                                                'cream' => 'Cream',
                                                'spotlight' => 'Spotlight'
                                            ])
                                            ->columnSpan(2),
                    
                                        TextInput::make('jumlah')
                                            ->numeric()
                                            ->default(1)
                                            ->required()
                                            ->minValue(1)
                                            ->columnSpan(2)
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_harga', 
                                            $state*$get('harga'))), 
                    
                                        TextInput::make('harga')
                                            ->numeric()
                                            ->required()
                                            ->disabled()
                                            ->dehydrated()
                                            ->columnSpan(2), 
                    
                                        TextInput::make('total_harga')
                                            ->numeric()
                                            ->required()
                                            ->dehydrated()
                                            ->columnSpan(3),
                                    ]),
                            ])
                            ->columns(12),
                        Placeholder::make('total_placeholder')
                        ->label('Total')
                        ->content(function  (Get $get, Set $set){
                            $total = 0;
                            if (!$repeaters = $get('detail')){
                                return $total;
                            }
                            foreach ($repeaters as $key => $repeater){
                                $total += $get("detail.{$key}.total_harga");
                            }
                            
                            // Hitung diskon jika ada promo
                            $diskon = 0;
                            if ($promoId = $get('promo_id')) {
                                $promo = \App\Models\Promo::find($promoId);
                                if ($promo && $promo->aktif) {
                                    if ($promo->tipe === 'fix') {
                                        $diskon = $promo->diskon;
                                    } else if ($promo->tipe === 'persen') {
                                        $diskon = ($total * $promo->diskon) / 100;
                                    }
                                }
                            }
                            
                            $totalSetelahDiskon = $total - $diskon;
                            $set('total', $total);
                            $set('diskon', $diskon);
                            $set('total_setelah_diskon', $totalSetelahDiskon);
                            
                            return 'Rp ' . number_format($totalSetelahDiskon, 0, ',', '.');
                        }),
                        Hidden::make('total')
                        ->default(0),
                        Hidden::make('diskon')
                        ->default(0),
                        Hidden::make('total_setelah_diskon')
                        ->default(0),
                    ])->columnSpanFull(),
                                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama'),

                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d F Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('waktu')
                    ->label('Jam')
                    ->time('H:i'),     

                Tables\Columns\TextColumn::make('detail.paketFoto.nama_paket_foto')
                    ->label('Paket Foto')
                    ->listWithLineBreaks(),

                Tables\Columns\TextColumn::make('total')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('tipe_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'full' => 'success',
                        'dp' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),

                Tables\Columns\ImageColumn::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->size(100),
                
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        DatePicker::make('tanggal')->label('Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['tanggal'],
                            fn (Builder $query, $date): Builder => $query->whereDate('tanggal', $date),
                        );
                    }),
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->label('Status Pembayaran'),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->headerActions([
                Tables\Actions\Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $reservasis = Reservasii::with(['user', 'detail.paketFoto'])
                            ->whereBetween('tanggal', [$data['start_date'], $data['end_date']])
                            ->get();
                        
                        $pdf = Pdf::loadView('pdf.reservasi', [
                            'reservasis' => $reservasis,
                            'start_date' => $data['start_date'],
                            'end_date' => $data['end_date']
                        ]);
                        
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'reservasi.pdf');
                    })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // Hitung jumlah reservasi dengan status pending
        $pendingCount = static::getModel()::where('status_pembayaran', 'pending')->count();
        
        // Kembalikan jumlah jika ada, null jika tidak ada
        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string 
    {
        // Hitung jumlah reservasi dengan status pending
        $pendingCount = static::getModel()::where('status_pembayaran', 'pending')->count();
        
        // Kembalikan warna warning jika ada reservasi pending
        return $pendingCount > 0 ? 'warning' : null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservasiis::route('/'),
            'create' => Pages\CreateReservasii::route('/create'),
            'edit' => Pages\EditReservasii::route('/{record}/edit'),
            'view' => Pages\ViewReservasii::route('/{record}'),
        ];
    }
}
