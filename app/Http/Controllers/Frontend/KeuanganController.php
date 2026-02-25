<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanKeuanganExport;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Statistik
        $totalPemasukan = LaporanKeuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = LaporanKeuangan::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Calculate percentage (example: dari bulan lalu)
        $bulanLalu = now()->subMonth();
        $pemasukanBulanLalu = LaporanKeuangan::where('jenis', 'pemasukan')
            ->whereYear('tanggal', $bulanLalu->year)
            ->whereMonth('tanggal', $bulanLalu->month)
            ->sum('jumlah');
        
        $pengeluaranBulanLalu = LaporanKeuangan::where('jenis', 'pengeluaran')
            ->whereYear('tanggal', $bulanLalu->year)
            ->whereMonth('tanggal', $bulanLalu->month)
            ->sum('jumlah');

        $pemasukanPercentage = $pemasukanBulanLalu > 0 
            ? (($totalPemasukan - $pemasukanBulanLalu) / $pemasukanBulanLalu) * 100 
            : 0;
        
        $pengeluaranPercentage = $pengeluaranBulanLalu > 0 
            ? (($totalPengeluaran - $pengeluaranBulanLalu) / $pengeluaranBulanLalu) * 100 
            : 0;

        // Query untuk tabel
        $query = LaporanKeuangan::with('creator')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by month
        if ($request->filled('bulan')) {
            $date = \Carbon\Carbon::parse($request->bulan);
            $query->whereYear('tanggal', $date->year)
                  ->whereMonth('tanggal', $date->month);
        }

        // Filter by type
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('keterangan', 'like', "%{$search}%");
        }

        $transaksiList = $query->paginate(10);

        // Generate month options
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $months[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->isoFormat('MMMM YYYY')
            ];
        }

        return view('frontend.keuangan.index', compact(
            'totalPemasukan', 
            'totalPengeluaran', 
            'saldo',
            'pemasukanPercentage',
            'pengeluaranPercentage',
            'transaksiList',
            'months'
        ));
    }

   public function export(Request $request)
{
    $fileName = 'laporan-keuangan-' . now()->format('Y-m-d') . '.xlsx';

    return Excel::download(
        new LaporanKeuanganExport($request),
        $fileName
    );
}
}