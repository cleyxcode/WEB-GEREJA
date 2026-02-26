<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            
            return Auth::user()->role === 'admin'
                ? redirect('/admin')
                : redirect()->route('home');
        }

        return view('frontend.auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            
            if ($user->role === 'admin') {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Login berhasil! Mengalihkan ke panel admin...',
                    'redirect' => '/admin'
                ]);
            }

           
            return response()->json([
                'success'  => true,
                'message'  => 'Login berhasil! Selamat datang, ' . $user->name,
                'redirect' => route('home')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah'
        ], 401);
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        if (Auth::check()) {
            
            return Auth::user()->role === 'admin'
                ? redirect('/admin')
                : redirect()->route('home');
        }

        return view('frontend.auth.register');
    }

    /**
     * Proses registrasi (hanya untuk jemaat)
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi',
            'email.required'     => 'Email wajib diisi',
            'email.email'        => 'Format email tidak valid',
            'email.unique'       => 'Email sudah terdaftar',
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'jemaat', 
                'no_hp'    => $request->no_hp,
                'alamat'   => $request->alamat,
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'message'  => 'Registrasi berhasil! Selamat datang, ' . $user->name,
                'redirect' => route('home')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat registrasi'
            ], 500);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success'  => true,
            'message'  => 'Logout berhasil',
            'redirect' => route('login')
        ]);
    }
}