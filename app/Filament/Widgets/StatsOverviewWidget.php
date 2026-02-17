<?php

namespace App\Filament\Widgets;

use App\Models\JadwalIbadah;
use App\Models\Berita;
use App\Models\Pendaftaran;
use App\Models\LaporanKeuangan;
use App\Models\Saran;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalJemaat = User::where('role', 'jemaat')->count();
        $pendaftaranPending = Pendaftaran::where('status', 'pending')->count();
        $saranBaru = Saran::where('status', 'baru')->count();
        $jadwalMendatang = JadwalIbadah::where('tanggal', '>=', now())->count();
        
        return [
            Stat::make('Total Jemaat', $totalJemaat)
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([5, 10, 15, 12, 18, 20, 22]),

            Stat::make('Pendaftaran Pending', $pendaftaranPending)
                ->description('Menunggu persetujuan')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendaftaranPending > 0 ? 'warning' : 'success')
                ->chart([3, 5, 4, 6, 5, 7, 6]),

            Stat::make('Saran Baru', $saranBaru)
                ->description('Belum dibaca')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($saranBaru > 0 ? 'info' : 'success')
                ->chart([2, 4, 3, 5, 4, 6, 5]),

            Stat::make('Jadwal Mendatang', $jadwalMendatang)
                ->description('Ibadah yang akan datang')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary')
                ->chart([1, 2, 1, 3, 2, 3, 4]),
        ];
    }
}