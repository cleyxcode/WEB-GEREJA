<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('creator')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        $beritaList = $query->paginate(9);

        return view('frontend.berita.index', compact('beritaList'));
    }

    public function show($id)
    {
        $berita = Berita::with('creator')->findOrFail($id);

        $beritaLainnya = Berita::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.berita.show', compact('berita', 'beritaLainnya'));
    }
}