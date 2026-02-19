<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JadwalIbadah;
use App\Models\Berita;
use App\Models\Pendaftaran;
use App\Models\Saran;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_jemaat'      => User::where('role', 'jemaat')->count(),
            'jadwal_mendatang'  => JadwalIbadah::where('tanggal', '>=', now())->count(),
            'berita_terbaru'    => Berita::whereMonth('created_at', now()->month)->count(),
            'saran_belum_dibaca'=> Saran::where('status', 'baru')->count(),
        ];

        $jadwalTerdekat = JadwalIbadah::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->take(3)
            ->get();

        $beritaTerbaru = Berita::with('creator')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Galeri terbaru (foto pendaftaran yang disetujui)
        $galeriBeranda = Pendaftaran::with('user')
            ->where('status', 'disetujui')
            ->whereNotNull('foto')
            ->orderBy('updated_at', 'desc')
            ->take(6)
            ->get();

        return view('frontend.home', compact('stats', 'jadwalTerdekat', 'beritaTerbaru', 'galeriBeranda'));
    }
}