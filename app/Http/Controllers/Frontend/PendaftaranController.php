<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $pendaftaranList = $query->paginate(10);

        return view('frontend.pendaftaran.index', compact('pendaftaranList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:255',
            'jenis'          => 'required|in:baptis,sidi,nikah',
            'tanggal_daftar' => 'required|date|after_or_equal:' . now()->addDays(14)->format('Y-m-d'),
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'catatan'        => 'nullable|string|max:500',
        ], [
            'nama.required'                 => 'Nama wajib diisi',
            'jenis.required'                => 'Jenis layanan wajib dipilih',
            'jenis.in'                      => 'Jenis layanan tidak valid',
            'tanggal_daftar.required'       => 'Tanggal pelaksanaan wajib diisi',
            'tanggal_daftar.after_or_equal' => 'Tanggal pelaksanaan minimal 2 minggu dari hari ini',
            'foto.image'                    => 'File harus berupa gambar',
            'foto.mimes'                    => 'Format gambar harus jpg, jpeg, png, atau webp',
            'foto.max'                      => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('pendaftaran/foto', 'public');
            }

            $pendaftaran = Pendaftaran::create([
                'user_id'        => Auth::id(),
                'nama'           => $request->nama,
                'jenis'          => $request->jenis,
                'tanggal_daftar' => $request->tanggal_daftar,
                'foto'           => $fotoPath,
                'catatan'        => $request->catatan,
                'status'         => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil diajukan. Mohon tunggu konfirmasi dari majelis.',
                'data'    => $pendaftaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengajukan pendaftaran'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);

        if ($pendaftaran->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pendaftaran dengan status pending yang dapat dibatalkan'
            ], 403);
        }

        if ($pendaftaran->foto) {
            Storage::disk('public')->delete($pendaftaran->foto);
        }

        $pendaftaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dibatalkan'
        ]);
    }
}