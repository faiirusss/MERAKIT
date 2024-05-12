<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BarangMasuk;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\BarangMasukResource\Pages;
use App\Filament\Resources\BarangMasukResource\RelationManagers;
use App\Models\Kategori;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Barang Masuk';
    protected static ?string $modelLabel = 'Barang Masuk';
    protected static ?string $slug = 'barang-masuk';
    protected static ?string $navigationGroup = 'Product Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengrajin')
                    ->schema([
                        Select::make('pengrajin_id')
                        ->relationship(name: 'pengrajin', titleAttribute: 'nama')
                        ->createOptionForm([
                            TextInput::make('nama')
                                ->maxLength(255)
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->required(),
                            TextInput::make('nomor')
                                ->tel()
                                ->required(),
                            DatePicker::make('start_at')
                                ->required(), 
                            ])
                        ->noSearchResultsMessage('Pengrajin tidak ada.')                            
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->required(),
                        DatePicker::make('tanggal_masuk')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(),
                    ])->columns(2),

                Section::make('Informasi Produk')
                    ->schema([

                        Select::make('produk_id')
                            ->relationship('produk', 'nama_produk')
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('nama_produk'),

                                Select::make('kategori_id')
                                ->relationship('kategori','kategori_name')
                                ->createOptionForm([
                                    TextInput::make('kategori_name')
                                    ->required()
                                ])
                                ->preload()
                                ->searchable()
                                ->native(false),

                                TextInput::make('harga')
                                ->numeric()
                                ->required()
                            ])
                            ->native(false)
                            ->preload()
                            ->required(),
                        TextInput::make('warna')
                            ->required(),
                        // Select::make('kategori_id')
                        //     ->relationship(name: 'kategori', titleAttribute: 'kategori_name')
                        //     ->createOptionForm([
                        //         TextInput::make('kategori_name')
                        //         ->required()
                        //     ])
                        //     ->noSearchResultsMessage('Kategori tidak tersedia.')                            
                        //     ->native(false)
                        //     ->searchable()
                        //     ->preload()
                        //     ->required(),
                        Select::make('kondisi')
                            ->options([
                                'Baru' => 'Baru',
                                'Bekas' => 'Bekas'
                            ])
                            ->native(false)
                            ->required(),                        
                        TextInput::make('status')
                            ->label('Status Barang')
                            ->placeholder('Aktif')
                            ->readOnly(true)
                            ->default('Aktif'),
                        TextInput::make('stok')
                            ->numeric()
                            ->required(),
                        TextInput::make('sku')
                            ->required(),
                        RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('foto')
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('produk.nama_produk')
                ->searchable(),
                TextColumn::make('pengrajin.nama'),
                TextColumn::make('produk.kategori.kategori_name')->label('Kategori'),
                TextColumn::make('warna')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'hitam' => 'gray',
                    'merah' => 'warning',
                    'biru' => 'success',
                    'kuning' => 'danger',
                }),
                TextColumn::make('produk.harga')
                ->sortable(),
                TextColumn::make('stok')
                ->sortable(),
                TextColumn::make('tanggal_masuk')
                ->sortable(),
            ])
            ->filters([
                SelectFilter::make('Kategori')
                ->relationship('kategori', 'kategori_name')
                ->native(false)
                ->preload(),
                SelectFilter::make('Pengrajin')
                ->relationship('pengrajin', 'nama')
                ->native(false)
                ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBarangMasuks::route('/'),
            'create' => Pages\CreateBarangMasuk::route('/create'),
            'view' => Pages\ViewBarangMasuk::route('/{record}'),
            'edit' => Pages\EditBarangMasuk::route('/{record}/edit'),
        ];
    }
}
