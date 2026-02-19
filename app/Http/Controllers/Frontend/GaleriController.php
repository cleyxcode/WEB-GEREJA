<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with('user')
            ->where('status', 'disetujui')
            ->whereNotNull('foto')
            ->orderBy('updated_at', 'desc');

        // Filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Search nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $galeri = $query->paginate(12);

        return view('frontend.galeri.index', compact('galeri'));
    }
}