<?php

namespace App\Filament\Resources\JemaatResource\Pages;

use App\Filament\Resources\JemaatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJemaats extends ListRecords
{
    protected static string $resource = JemaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Jemaat'),
        ];
    }
}