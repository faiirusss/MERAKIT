<?php

namespace App\Filament\Resources\ReportBarangKeluarResource\Pages;

use App\Filament\Resources\ReportBarangKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportBarangKeluar extends EditRecord
{
    protected static string $resource = ReportBarangKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
