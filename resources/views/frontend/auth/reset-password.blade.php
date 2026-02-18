@extends('frontend.layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="bg-gradient-mesh min-h-screen flex flex-col items-center justify-center p-4">
    <main class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-card w-full overflow-hidden border border-slate-100 transition-all duration-300">

            {{-- Header --}}
            <div class="pt-10 pb-6 px-8 text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-sm">
                    <span class="material-symbols-outlined text-[40px]">key</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2 tracking-tight">Buat Password Baru</h1>
                <p class="text-slate-500 text-sm leading-relaxed text-center">
                    Masukkan password baru Anda di bawah ini.
                </p>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mx-8 mb-2 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    <span class="material-symbols-outlined text-[20px] mt-0.5 shrink-0">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form id="resetForm" method="POST" action="{{ route('password.store') }}" class="px-8 pb-10 flex flex-col gap-5">
                @csrf

                {{-- Token (hidden) --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div class="flex flex-col gap-1.5 group/email">
                    <label class="text-sm font-medium text-slate-700" for="email">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within/email:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input
                            class="block w-full rounded-lg border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 @error('email') border-red-400 bg-red-50 @enderror"
                            id="email"
                            name="email"
                            placeholder="nama@email.com"
                            required
                            type="email"
                            value="{{ old('email', $request->email) }}"
                            autofocus
                        />
                    </div>
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="flex flex-col gap-1.5 group/password">
                    <label class="text-sm font-medium text-slate-700" for="password">Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within/password:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input
                            class="block w-full rounded-lg border border-slate-200 bg-slate-50 pl-11 pr-10 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 @error('password') border-red-400 bg-red-50 @enderror"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            type="password"
                            autocomplete="new-password"
                        />
                        <button
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
                            type="button"
                            onclick="togglePassword('password', 'eye1')"
                        >
                            <span id="eye1" class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror

                    {{-- Password Strength Bar --}}
                    <div id="strength-wrap" class="hidden mt-1">
                        <div class="flex gap-1 mb-1">
                            <div class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300" id="s1"></div>
                            <div class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300" id="s2"></div>
                            <div class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300" id="s3"></div>
                            <div class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300" id="s4"></div>
                        </div>
                        <span id="strength-label" class="text-xs text-slate-400"></span>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="flex flex-col gap-1.5 group/confirm">
                    <label class="text-sm font-medium text-slate-700" for="password_confirmation">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within/confirm:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">lock_clock</span>
                        </div>
                        <input
                            class="block w-full rounded-lg border border-slate-200 bg-slate-50 pl-11 pr-10 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="••••••••"
                            required
                            type="password"
                            autocomplete="new-password"
                        />
                        <button
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
                            type="button"
                            onclick="togglePassword('password_confirmation', 'eye2')"
                        >
                            <span id="eye2" class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    <span id="confirm-error" class="text-xs text-red-500 hidden">Password tidak cocok</span>
                </div>

                {{-- Submit Button --}}
                <button
                    id="submitBtn"
                    class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-4 rounded-lg shadow-soft hover:shadow-lg hover:shadow-primary/30 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 mt-2"
                    type="submit"
                >
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span>Simpan Password Baru</span>
                </button>

                {{-- Back to Login --}}
                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Kembali ke halaman login
                    </a>
                </div>
            </form>
        </div>

        {{-- Footer links --}}
        <div class="mt-8 flex justify-center gap-6 text-xs text-slate-500">
            <a class="hover:text-slate-700 transition-colors" href="#">Bantuan</a>
            <a class="hover:text-slate-700 transition-colors" href="#">Privasi</a>
            <a class="hover:text-slate-700 transition-colors" href="#">Ketentuan</a>
        </div>
    </main>

    {{-- Background Decoration --}}
    <div class="fixed bottom-0 left-0 w-full h-1/2 pointer-events-none -z-10 opacity-30 bg-cover bg-bottom"
        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCJTmBqVxFf-S7S0_xExbx38O1UVDKOpMfAxQliSDAiPxP86pW8N8k01-dPhV5zSudmm8S7No9s2CTuws4GyXD_kOmWX4lI9Btnm_yah-PZEp1_LtTKreU5SyzzRPedVvQ4NhjzLmb9l_WsfE_F0nKsZjuZfqpR5gXi-2CLUrDY3beZP73j2PRvVVG3SazrdySbGnpUcYk3YYqwr-GroCbZhGv3utpJt2xfJscfcIuLx_aq-DBo0nGBxBTSl-U5TLZGzeJwm5Li62UI');
              mask-image: linear-gradient(to top, black, transparent);">
    </div>
</div>
@endsection

@push('scripts')
<script>
// Toggle show/hide password
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}

// Password strength
const pwInput     = document.getElementById('password');
const strengthWrap = document.getElementById('strength-wrap');
const strengthLabel = document.getElementById('strength-label');
const bars = ['s1','s2','s3','s4'].map(id => document.getElementById(id));

const colorMap = ['bg-red-400','bg-orange-400','bg-yellow-400','bg-green-500'];
const labelMap = ['Sangat Lemah','Lemah','Cukup','Kuat'];
const textMap  = ['text-red-500','text-orange-500','text-yellow-600','text-green-600'];

pwInput.addEventListener('input', function () {
    const v = this.value;
    if (!v) { strengthWrap.classList.add('hidden'); return; }
    strengthWrap.classList.remove('hidden');

    let score = 0;
    if (v.length >= 8)          score++;
    if (/[A-Z]/.test(v))        score++;
    if (/[0-9]/.test(v))        score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;

    bars.forEach((bar, i) => {
        bar.className = 'h-1 flex-1 rounded-full transition-colors duration-300 ' +
            (i < score ? colorMap[score - 1] : 'bg-slate-200');
    });
    strengthLabel.textContent = labelMap[score - 1] || '';
    strengthLabel.className   = 'text-xs ' + (textMap[score - 1] || 'text-slate-400');
});

// Confirm password match
document.getElementById('password_confirmation').addEventListener('input', function () {
    const err = document.getElementById('confirm-error');
    err.classList.toggle('hidden', !this.value || this.value === pwInput.value);
});

// Submit
document.getElementById('resetForm').addEventListener('submit', function (e) {
    const pass    = pwInput.value;
    const confirm = document.getElementById('password_confirmation').value;
    if (pass !== confirm) {
        e.preventDefault();
        document.getElementById('confirm-error').classList.remove('hidden');
        return;
    }
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <span>Memproses...</span>
    `;
});
</script>
@endpush