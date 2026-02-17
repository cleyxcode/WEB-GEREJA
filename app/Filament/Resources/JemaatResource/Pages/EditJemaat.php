<?php

namespace App\Filament\Resources\JemaatResource\Pages;

use App\Filament\Resources\JemaatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJemaat extends EditRecord
{
    protected static string $resource = JemaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data jemaat berhasil diupdate';
    }
}