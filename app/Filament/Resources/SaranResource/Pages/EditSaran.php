<?php

namespace App\Filament\Resources\SaranResource\Pages;

use App\Filament\Resources\SaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaran extends EditRecord
{
    protected static string $resource = SaranResource::class;

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
}