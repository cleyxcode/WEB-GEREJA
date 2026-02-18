@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')
<div class="bg-gradient-mesh min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Main Container -->
    <main class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-card w-full overflow-hidden border border-slate-100 transition-all duration-300">
            <!-- Header Section with Logo -->
            <div class="pt-10 pb-6 px-8 text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-sm">
                    <span class="material-symbols-outlined text-[40px]">church</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2 tracking-tight">Gereja Bethesda</h1>
                <p class="text-slate-500 text-sm">Masuk untuk mengakses sistem informasi gereja</p>
            </div>

            {{-- Alert status (setelah reset password berhasil) --}}
            @if (session('status'))
                <div class="mx-8 mb-2 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    <span class="material-symbols-outlined text-[20px] mt-0.5 shrink-0">check_circle</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Form Section -->
            <form id="loginForm" class="px-8 pb-10 flex flex-col gap-5">
                @csrf

                <!-- Email Input Group -->
                <div class="flex flex-col gap-1.5 group/email">
                    <label class="text-sm font-medium text-slate-700" for="email">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within/email:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input
                            class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-10 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                            id="email"
                            name="email"
                            placeholder="nama@email.com"
                            required
                            type="email"
                        />
                    </div>
                    <span class="text-xs text-red-500 hidden" id="email-error"></span>
                </div>

                <!-- Password Input Group -->
                <div class="flex flex-col gap-1.5 group/password">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-slate-700" for="password">Password</label>
                        {{-- ✅ Link lupa password diperbaiki --}}
                        <a class="text-xs font-medium text-primary hover:text-primary-hover hover:underline transition-colors" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within/password:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input
                            class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-10 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            type="password"
                        />
                        <button
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
                            type="button"
                            data-toggle-password
                        >
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    <span class="text-xs text-red-500 hidden" id="password-error"></span>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center gap-2">
                    <input class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/20 cursor-pointer" id="remember" name="remember" type="checkbox" />
                    <label class="text-sm text-slate-600 cursor-pointer select-none" for="remember">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    id="submitBtn"
                    class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-4 rounded-lg shadow-soft hover:shadow-lg hover:shadow-primary/30 active:transform active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 mt-2"
                    type="submit"
                >
                    <span>Masuk</span>
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </button>
            </form>

            <!-- Footer / Registration Link -->
            <div class="bg-slate-50 py-4 text-center border-t border-slate-100">
                <p class="text-sm text-slate-600">
                    Belum punya akun?
                    <a class="text-primary font-medium hover:text-primary-hover hover:underline transition-colors ml-1" href="{{ route('register') }}">
                        Daftar disini
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Links -->
        <div class="mt-8 flex justify-center gap-6 text-xs text-slate-500">
            <a class="hover:text-slate-700 transition-colors" href="#">Bantuan</a>
            <a class="hover:text-slate-700 transition-colors" href="#">Privasi</a>
            <a class="hover:text-slate-700 transition-colors" href="#">Ketentuan</a>
        </div>
    </main>

    <!-- Background Decoration -->
    <div class="fixed bottom-0 left-0 w-full h-1/2 pointer-events-none -z-10 opacity-30 bg-cover bg-bottom"
        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCJTmBqVxFf-S7S0_xExbx38O1UVDKOpMfAxQliSDAiPxP86pW8N8k01-dPhV5zSudmm8S7No9s2CTuws4GyXD_kOmWX4lI9Btnm_yah-PZEp1_LtTKreU5SyzzRPedVvQ4NhjzLmb9l_WsfE_F0nKsZjuZfqpR5gXi-2CLUrDY3beZP73j2PRvVVG3SazrdySbGnpUcYk3YYqwr-GroCbZhGv3utpJt2xfJscfcIuLx_aq-DBo0nGBxBTSl-U5TLZGzeJwm5Li62UI');
              mask-image: linear-gradient(to top, black, transparent);">
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const email    = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    let isValid = true;

    if (!validateEmail(email)) {
        document.getElementById('email-error').textContent = 'Email tidak valid';
        document.getElementById('email-error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('email-error').classList.add('hidden');
    }

    if (!validatePassword(password)) {
        document.getElementById('password-error').textContent = 'Password minimal 8 karakter';
        document.getElementById('password-error').classList.remove('hidden');
        isValid = false;
    } else {
        document.getElementById('password-error').classList.add('hidden');
    }

    if (!isValid) return;

    setButtonLoading(submitBtn, true);

    try {
        const response = await fetch('{{ route("login.post") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email, password, remember })
        });

        const data = await response.json();

        if (response.ok) {
            showToast('Login berhasil! Mengalihkan...', 'success');
            setTimeout(() => {
                window.location.href = data.redirect || '{{ route("home") }}';
            }, 1000);
        } else {
            showToast(data.message || 'Login gagal. Periksa email dan password Anda.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <span>Masuk</span>
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            `;
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <span>Masuk</span>
            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
        `;
    }
});
</script>
@endpush