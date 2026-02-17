<?php

namespace App\Filament\Resources\SaranResource\Pages;

use App\Filament\Resources\SaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSaran extends CreateRecord
{
    protected static string $resource = SaranResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}