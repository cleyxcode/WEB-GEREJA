<?php

namespace App\Filament\Resources\JadwalIbadahResource\Pages;

use App\Filament\Resources\JadwalIbadahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalIbadah extends EditRecord
{
    protected static string $resource = JadwalIbadahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}