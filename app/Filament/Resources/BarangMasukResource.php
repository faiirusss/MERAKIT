<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BarangMasuk;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangMasukResource\Pages;
use App\Filament\Resources\BarangMasukResource\RelationManagers;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Barang Masuk';
    protected static ?string $modelLabel = 'Barang Masuk';
    protected static ?string $slug = 'barang-masuk';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengrajin')
                    ->schema([
                        TextInput::make('Pengrajin')
                            ->required(),
                        DatePicker::make('Tanggal')
                            ->required(),
                    ])->columns(2),
                Section::make('Informasi Produk')
                    ->schema([
                        TextInput::make('Nama Produk')
                            ->required(),
                        TextInput::make('Warna')
                            ->required(),
                        TextInput::make('Kategori')
                            ->required(),
                        Select::make('Kondisi')
                            ->options([
                                'Baru' => 'Baru',
                                'Bekas' => 'Bekas'
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('Harga')
                            ->required(),
                        TextInput::make('Status Produk')
                            ->placeholder('Aktif')
                            ->disabled(),
                        TextInput::make('Stok')
                            ->numeric()
                            ->required(),
                        TextInput::make('SKU')
                            ->required(),
                        RichEditor::make('Deskripsi')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
