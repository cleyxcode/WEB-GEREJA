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


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Home/Dashboard User
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Jadwal Ibadah
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('/jadwal/{id}/download-liturgi', [JadwalController::class, 'downloadLiturgi'])->name('jadwal.download-liturgi');
    
    // Routes placeholder (akan dibuat nanti)
    Route::get('/berita', function() { return 'Halaman Berita'; })->name('berita.index');
    Route::get('/berita/{id}', function() { return 'Detail Berita'; })->name('berita.show');
    Route::get('/pendaftaran', function() { return 'Halaman Pendaftaran'; })->name('pendaftaran.index');
    Route::get('/keuangan', function() { return 'Halaman Keuangan'; })->name('keuangan.index');
    Route::get('/saran', function() { return 'Halaman Saran'; })->name('saran.create');
    Route::get('/profile', function() { return 'Halaman Profile'; })->name('profile');
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('/keuangan/export', [KeuanganController::class, 'export'])->name('keuangan.export');
    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    Route::get('/saran', [SaranController::class, 'index'])->name('saran.create');
    Route::post('/saran', [SaranController::class, 'store'])->name('saran.store');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

     Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
});