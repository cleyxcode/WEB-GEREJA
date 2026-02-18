<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Gereja Bethesda</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:40px 16px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                {{-- Card --}}
                <tr>
                    <td style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

                        {{-- Header --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:36px 32px;text-align:center;">
                                    <div style="width:72px;height:72px;background:rgba(255,255,255,0.15);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;">
                                        <span style="font-size:36px;">⛪</span>
                                    </div>
                                    <h1 style="color:#ffffff;font-size:22px;font-weight:700;margin:0 0 6px;letter-spacing:-0.3px;">Gereja Bethesda</h1>
                                    <p style="color:rgba(255,255,255,0.8);font-size:14px;margin:0;">Sistem Informasi Jemaat</p>
                                </td>
                            </tr>
                        </table>

                        {{-- Body --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:36px 32px;">
                                    <p style="font-size:16px;font-weight:600;color:#1e293b;margin:0 0 12px;">Halo, {{ $user->name ?? 'Pengguna' }}!</p>
                                    <p style="font-size:14px;color:#64748b;line-height:1.7;margin:0 0 28px;">
                                        Kami menerima permintaan untuk mereset password akun Anda di
                                        <strong>Sistem Informasi Gereja Bethesda</strong>.
                                        Klik tombol di bawah ini untuk membuat password baru.
                                        Link ini hanya berlaku selama <strong>60 menit</strong>.
                                    </p>

                                    {{-- CTA Button --}}
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding-bottom:28px;">
                                                <a href="{{ $url }}"
                                                    style="display:inline-block;background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);color:#ffffff;text-decoration:none;font-weight:600;font-size:15px;padding:14px 40px;border-radius:10px;">
                                                    🔐 &nbsp; Reset Password Saya
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Divider --}}
                                    <hr style="border:none;border-top:1px solid #e2e8f0;margin:0 0 24px;">

                                    {{-- Note --}}
                                    <p style="font-size:12px;color:#94a3b8;line-height:1.6;margin:0 0 16px;">
                                        <strong>Tidak merasa meminta reset password?</strong><br>
                                        Abaikan email ini — password Anda tidak akan berubah.
                                        Jika Anda khawatir dengan keamanan akun, segera hubungi admin gereja.
                                    </p>

                                    {{-- Fallback link --}}
                                    <p style="font-size:12px;color:#64748b;margin:0 0 8px;">
                                        Jika tombol tidak berfungsi, salin link berikut ke browser Anda:
                                    </p>
                                    <p style="font-size:12px;color:#4f46e5;word-break:break-all;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px;margin:0;">
                                        {{ $url }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        {{-- Footer --}}
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background:#f8fafc;padding:20px 32px;text-align:center;border-top:1px solid #e2e8f0;">
                                    <p style="font-size:12px;color:#94a3b8;margin:0;">
                                        Email ini dikirim oleh <strong>Gereja Bethesda</strong><br>
                                        &copy; {{ date('Y') }} Sistem Informasi Gereja Bethesda. Seluruh hak dilindungi.
                                    </p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>