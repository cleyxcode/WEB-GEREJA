@extends('frontend.layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="bg-gradient-mesh min-h-screen flex flex-col items-center justify-center p-4">
    <main class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-card w-full overflow-hidden border border-slate-100 transition-all duration-300">

            {{-- Header --}}
            <div class="pt-10 pb-6 px-8 text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-sm">
                    <span class="material-symbols-outlined text-[40px]">lock_reset</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2 tracking-tight">Lupa Password?</h1>
                <p class="text-slate-500 text-sm leading-relaxed text-center">
                    Masukkan email Anda dan kami akan mengirimkan<br>link untuk mereset password.
                </p>
            </div>

            {{-- Alert Status Sukses --}}
            @if (session('status'))
                <div class="mx-8 mb-2 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    <span class="material-symbols-outlined text-[20px] mt-0.5 shrink-0">check_circle</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mx-8 mb-2 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    <span class="material-symbols-outlined text-[20px] mt-0.5 shrink-0">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form id="forgotForm" method="POST" action="{{ route('password.email') }}" class="px-8 pb-10 flex flex-col gap-5">
                @csrf

                {{-- Email --}}
                <div class="flex flex-col gap-1.5 group/email">
                    <label class="text-sm font-medium text-slate-700" for="email">Alamat Email</label>
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
                            value="{{ old('email') }}"
                            autofocus
                        />
                    </div>
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button
                    id="submitBtn"
                    class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-4 rounded-lg shadow-soft hover:shadow-lg hover:shadow-primary/30 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 mt-2"
                    type="submit"
                >
                    <span class="material-symbols-outlined text-[20px]">send</span>
                    <span>Kirim Link Reset</span>
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
document.getElementById('forgotForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <span>Mengirim...</span>
    `;
});
</script>
@endpush