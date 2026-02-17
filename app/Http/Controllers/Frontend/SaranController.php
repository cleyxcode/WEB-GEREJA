<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Saran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SaranController extends Controller
{
    public function index()
    {
        // Get user's saran history
        $saranList = Saran::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.saran.index', compact('saranList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isi_saran' => 'required|string|min:10|max:1000',
        ], [
            'isi_saran.required' => 'Isi saran wajib diisi',
            'isi_saran.min' => 'Saran minimal 10 karakter',
            'isi_saran.max' => 'Saran maksimal 1000 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $saran = Saran::create([
                'user_id' => Auth::id(),
                'isi_saran' => $request->isi_saran,
                'status' => 'baru',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Saran berhasil dikirim. Terima kasih atas partisipasi Anda!',
                'data' => $saran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim saran'
            ], 500);
        }
    }
}