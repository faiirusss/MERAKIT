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
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengrajin')
                    ->schema([
                        TextInput::make('Nama')
                            ->required(),
                        TextInput::make('Email')
                            ->email()
                            ->required(),
                        TextInput::make('Telepon')
                            ->required(),
                        DatePicker::make('Tanggal')
                            ->required(),
                        Select::make('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'InActive'
                            ])
                            ->native(false)
                            ->required()
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
            'index' => Pages\ListPengrajins::route('/'),
            'create' => Pages\CreatePengrajin::route('/create'),
            'view' => Pages\ViewPengrajin::route('/{record}'),
            'edit' => Pages\EditPengrajin::route('/{record}/edit'),
        ];
    }
}
