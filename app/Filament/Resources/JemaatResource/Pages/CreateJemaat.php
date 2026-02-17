<?php

namespace App\Filament\Resources\JemaatResource\Pages;

use App\Filament\Resources\JemaatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJemaat extends CreateRecord
{
    protected static string $resource = JemaatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Jemaat berhasil ditambahkan';
    }
}