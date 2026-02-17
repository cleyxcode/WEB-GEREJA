<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JadwalIbadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalIbadah::where('tanggal', '>=', now()->startOfDay())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc');

        // Filter by month
        if ($request->filled('bulan')) {
            $date = \Carbon\Carbon::parse($request->bulan);
            $query->whereYear('tanggal', $date->year)
                  ->whereMonth('tanggal', $date->month);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('petugas_ibadah', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%")
                  ->orWhere('liturgi_text', 'like', "%{$search}%");
            });
        }

        $jadwalList = $query->paginate(9);

        // Jadwal terdekat untuk featured card
        $jadwalTerdekat = JadwalIbadah::where('tanggal', '>=', now()->startOfDay())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->first();

        // Generate month options for filter
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $date = now()->addMonths($i);
            $months[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->isoFormat('MMMM YYYY')
            ];
        }

        return view('frontend.jadwal.index', compact('jadwalList', 'jadwalTerdekat', 'months'));
    }

    public function show($id)
    {
        $jadwal = JadwalIbadah::with('creator')->findOrFail($id);
        
        return view('frontend.jadwal.show', compact('jadwal'));
    }

    public function downloadLiturgi($id)
    {
        $jadwal = JadwalIbadah::findOrFail($id);
        
        if (!$jadwal->liturgi_file) {
            return back()->with('error', 'File liturgi tidak tersedia');
        }

        $filePath = $jadwal->liturgi_file;
        
        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($filePath);
    }
}