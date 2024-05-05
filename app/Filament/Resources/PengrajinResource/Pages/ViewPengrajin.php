<?php

namespace App\Filament\Resources\PengrajinResource\Pages;

use App\Filament\Resources\PengrajinResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPengrajin extends ViewRecord
{
    protected static string $resource = PengrajinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
