<?php

namespace App\Filament\Resources\ReportBarangMasukResource\Pages;

use App\Filament\Resources\ReportBarangMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportBarangMasuk extends EditRecord
{
    protected static string $resource = ReportBarangMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
