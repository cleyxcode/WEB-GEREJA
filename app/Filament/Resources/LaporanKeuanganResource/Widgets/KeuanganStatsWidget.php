<?php

namespace App\Filament\Resources\LaporanKeuanganResource\Widgets;

use App\Models\LaporanKeuangan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KeuanganStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $pemasukan = LaporanKeuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $pengeluaran = LaporanKeuangan::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        return [
            Stat::make('Total Pemasukan', 'Rp ' . number_format($pemasukan, 0, ',', '.'))
                ->description('Total semua pemasukan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($pengeluaran, 0, ',', '.'))
                ->description('Total semua pengeluaran')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([3, 5, 3, 6, 5, 4, 3, 7]),

            Stat::make('Saldo', 'Rp ' . number_format($saldo, 0, ',', '.'))
                ->description($saldo >= 0 ? 'Surplus' : 'Defisit')
                ->descriptionIcon($saldo >= 0 ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle')
                ->color($saldo >= 0 ? 'success' : 'warning'),
        ];
    }
}