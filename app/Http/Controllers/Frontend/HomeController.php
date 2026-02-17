<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JadwalIbadah;
use App\Models\Berita;
use App\Models\Pendaftaran;
use App\Models\LaporanKeuangan;
use App\Models\Saran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik
        $stats = [
            'total_jemaat' => User::where('role', 'jemaat')->count(),
            'jadwal_mendatang' => JadwalIbadah::where('tanggal', '>=', now())->count(),
            'berita_terbaru' => Berita::whereMonth('created_at', now()->month)->count(),
            'saran_belum_dibaca' => Saran::where('status', 'baru')->count(),
        ];

        // Jadwal Ibadah Terdekat (3 jadwal)
        $jadwalTerdekat = JadwalIbadah::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->take(3)
            ->get();

        // Berita Terbaru (3 berita)
        $beritaTerbaru = Berita::with('creator')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.home', compact('stats', 'jadwalTerdekat', 'beritaTerbaru'));
    }
}