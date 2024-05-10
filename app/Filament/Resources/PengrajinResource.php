<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengrajinResource\Pages;
use App\Filament\Resources\PengrajinResource\RelationManagers;
use App\Models\Pengrajin;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengrajinResource extends Resource
{
    protected static ?string $model = Pengrajin::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengrajin';
    protected static ?string $modelLabel = 'Pengrajin';
    protected static ?string $slug = 'pengrajin';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengrajin')
                    ->schema([
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
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                ->rowIndex(),
                TextColumn::make('nama')
                ->searchable(),
                TextColumn::make('email'),
                TextColumn::make('nomor'),
                TextColumn::make('start_at')
                ->date(),
                TextColumn::make('barangmasuk_count')->counts('barangmasuk')
                ->label('Total Barang Dikirim'),
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
            'index' => Pages\ListPengrajins::route('/'),
            'create' => Pages\CreatePengrajin::route('/create'),
            'view' => Pages\ViewPengrajin::route('/{record}'),
            'edit' => Pages\EditPengrajin::route('/{record}/edit'),
        ];
    }
}
