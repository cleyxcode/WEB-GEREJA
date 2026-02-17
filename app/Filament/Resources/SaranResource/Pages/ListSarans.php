<?php

namespace App\Filament\Resources\SaranResource\Pages;

use App\Filament\Resources\SaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSarans extends ListRecords
{
    protected static string $resource = SaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}