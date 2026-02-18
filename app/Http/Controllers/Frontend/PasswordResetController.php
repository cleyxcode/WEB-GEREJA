<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Tampilkan halaman lupa password (form input email)
     */
    public function showForgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * Proses kirim link reset password ke email user
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email'    => 'Format email tidak valid',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Link reset password telah dikirim ke email Anda. Periksa inbox atau folder spam.');
        }

        return back()->withErrors([
            'email' => $this->getFriendlyError($status),
        ]);
    }

    /**
     * Tampilkan halaman reset password (form input password baru)
     * Dipanggil dari link di email
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('frontend.auth.reset-password', [
            'request' => $request,
            'token'   => $token,
        ]);
    }

    /**
     * Proses simpan password baru
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'token.required'     => 'Token reset tidak valid',
            'email.required'     => 'Email wajib diisi',
            'email.email'        => 'Format email tidak valid',
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Password berhasil direset! Silakan login dengan password baru Anda.');
        }

        return back()->withErrors([
            'email' => $this->getFriendlyError($status),
        ]);
    }

    /**
     * Terjemahkan pesan error Laravel ke Bahasa Indonesia
     */
    private function getFriendlyError(string $status): string
    {
        return match ($status) {
            Password::INVALID_USER  => 'Email tidak terdaftar di sistem kami.',
            Password::INVALID_TOKEN => 'Link reset password tidak valid atau sudah kadaluarsa. Silakan minta link baru.',
            Password::RESET_THROTTLED => 'Terlalu banyak permintaan. Silakan tunggu beberapa menit.',
            default => 'Terjadi kesalahan. Silakan coba lagi.',
        };
    }
}