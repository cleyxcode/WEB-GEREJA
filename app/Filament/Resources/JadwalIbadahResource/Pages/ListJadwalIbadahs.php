<?php

namespace App\Filament\Resources\JadwalIbadahResource\Pages;

use App\Filament\Resources\JadwalIbadahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalIbadahs extends ListRecords
{
    protected static string $resource = JadwalIbadahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
