<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKeuangan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class KeuanganChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafik Keuangan (6 Bulan Terakhir)';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $now = now();
        $months = collect();
        
        // Ambil 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $months->push([
                'month' => $date->format('M Y'),
                'year' => $date->year,
                'month_num' => $date->month,
            ]);
        }

        $pemasukan = [];
        $pengeluaran = [];

        foreach ($months as $month) {
            $pemasukanTotal = LaporanKeuangan::where('jenis', 'pemasukan')
                ->whereYear('tanggal', $month['year'])
                ->whereMonth('tanggal', $month['month_num'])
                ->sum('jumlah');
            
            $pengeluaranTotal = LaporanKeuangan::where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $month['year'])
                ->whereMonth('tanggal', $month['month_num'])
                ->sum('jumlah');

            $pemasukan[] = $pemasukanTotal;
            $pengeluaran[] = $pengeluaranTotal;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $pemasukan,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $pengeluaran,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'borderColor' => 'rgb(239, 68, 68)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $months->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toLocaleString("id-ID"); }',
                    ],
                ],
            ],
        ];
    }
}