<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportBarangMasukResource\Pages;
use App\Filament\Resources\ReportBarangMasukResource\RelationManagers;
use App\Models\ReportBarangMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportBarangMasukResource extends Resource
{
    protected static ?string $model = ReportBarangMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListReportBarangMasuks::route('/'),
            'create' => Pages\CreateReportBarangMasuk::route('/create'),
            'edit' => Pages\EditReportBarangMasuk::route('/{record}/edit'),
        ];
    }
}
