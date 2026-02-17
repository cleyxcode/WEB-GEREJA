<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureJemaat
{
    public function handle(Request $request, Closure $next)
    {
        // Belum login → ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Admin coba akses halaman jemaat → paksa ke /admin
        if (Auth::user()->role === 'admin') {
            return redirect('/admin');
        }

        return $next($request);
    }
}