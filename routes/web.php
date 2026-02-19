<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\JadwalController;
use App\Http\Controllers\Frontend\KeuanganController;
use App\Http\Controllers\Frontend\PendaftaranController;
use App\Http\Controllers\Frontend\SaranController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\BeritaController;
use App\Http\Controllers\Frontend\GaleriController;

// ✅ Import controller reset password
use App\Http\Controllers\Frontend\PasswordResetController;

// ─── Root redirect ────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// ─── Guest routes (belum login) ───────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // ✅ Reset Password
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.store');

});

// ─── Authenticated routes ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Home/Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Jadwal Ibadah
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('/jadwal/{id}/download-liturgi', [JadwalController::class, 'downloadLiturgi'])->name('jadwal.download-liturgi');

    // Berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

    // Keuangan
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('/keuangan/export', [KeuanganController::class, 'export'])->name('keuangan.export');

    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    // Saran
    Route::get('/saran', [SaranController::class, 'index'])->name('saran.create');
    Route::post('/saran', [SaranController::class, 'store'])->name('saran.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

});