<?php

namespace App\Filament\Resources\JemaatResource\Pages;

use App\Filament\Resources\JemaatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewJemaat extends ViewRecord
{
    protected static string $resource = JemaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Informasi Akun')
                    ->schema([
                        Components\TextEntry::make('name')
                            ->label('Nama Lengkap'),
                        Components\TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                        Components\TextEntry::make('role')
                            ->label('Role')
                            ->badge()
                            ->color('success'),
                    ])
                    ->columns(3),

                Components\Section::make('Informasi Kontak')
                    ->schema([
                        Components\TextEntry::make('no_hp')
                            ->label('No. HP')
                            ->icon('heroicon-o-phone')
                            ->placeholder('Belum diisi'),
                        Components\TextEntry::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Belum diisi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Components\Section::make('Statistik')
                    ->schema([
                        Components\TextEntry::make('pendaftaran_count')
                            ->label('Total Pendaftaran')
                            ->state(fn ($record) => $record->pendaftaran()->count())
                            ->badge()
                            ->color('info'),
                        Components\TextEntry::make('saran_count')
                            ->label('Total Saran')
                            ->state(fn ($record) => $record->saran()->count())
                            ->badge()
                            ->color('success'),
                        Components\TextEntry::make('created_at')
                            ->label('Terdaftar Pada')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(3),
            ]);
    }
}