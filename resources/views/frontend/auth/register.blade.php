@extends('frontend.layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="bg-gradient-mesh min-h-screen flex flex-col items-center justify-center p-4 py-10">
    <!-- Main Container -->
    <main class="w-full max-w-2xl">
        <!-- Register Card -->
        <div class="bg-white rounded-xl shadow-card w-full overflow-hidden border border-slate-100 transition-all duration-300">
            <!-- Header Section with Logo -->
            <div class="pt-10 pb-6 px-8 text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-sm">
                    <span class="material-symbols-outlined text-[40px]">church</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2 tracking-tight">Daftar Akun Baru</h1>
                <p class="text-slate-500 text-sm">Lengkapi data diri Anda untuk mendaftar</p>
            </div>

            <!-- Form Section -->
            <form id="registerForm" class="px-8 pb-10 flex flex-col gap-5">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-slate-700" for="name">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">person</span>
                            </div>
                            <input 
                                class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" 
                                id="name" 
                                name="name" 
                                placeholder="Masukkan nama lengkap" 
                                required 
                                type="text"
                            />
                        </div>
                        <span class="text-xs text-red-500 hidden" id="name-error"></span>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-slate-700" for="email">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </div>
                            <input 
                                class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" 
                                id="email" 
                                name="email" 
                                placeholder="nama@email.com" 
                                required 
                                type="email"
                            />
                        </div>
                        <span class="text-xs text-red-500 hidden" id="email-error"></span>
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-700" for="password">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input 
                                class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-10 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" 
                                id="password" 
                                name="password" 
                                placeholder="Minimal 8 karakter" 
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

                    <!-- Konfirmasi Password -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-700" for="password_confirmation">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input 
                                class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-10 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Ulangi password" 
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
                        <span class="text-xs text-red-500 hidden" id="password_confirmation-error"></span>
                    </div>

                    <!-- No HP -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-700" for="no_hp">No. HP (Opsional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">phone</span>
                            </div>
                            <input 
                                class="block w-full rounded-lg border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" 
                                id="no_hp" 
                                name="no_hp" 
                                placeholder="08xxxxxxxxxx" 
                                type="tel"
                            />
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-slate-700" for="alamat">Alamat (Opsional)</label>
                        <textarea 
                            class="block w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-3 text-sm placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" 
                            id="alamat" 
                            name="alamat" 
                            placeholder="Masukkan alamat lengkap"
                            rows="3"
                        ></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    id="submitBtn"
                    class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-4 rounded-lg shadow-soft hover:shadow-lg hover:shadow-primary/30 active:transform active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 mt-2" 
                    type="submit"
                >
                    <span>Daftar</span>
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </button>
            </form>

            <!-- Footer / Login Link -->
            <div class="bg-slate-50 py-4 text-center border-t border-slate-100">
                <p class="text-sm text-slate-600">
                    Sudah punya akun? 
                    <a class="text-primary font-medium hover:text-primary-hover hover:underline transition-colors ml-1" href="{{ route('login') }}">
                        Masuk disini
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
    <div class="fixed bottom-0 left-0 w-full h-1/2 pointer-events-none -z-10 opacity-30 bg-cover bg-bottom" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCJTmBqVxFf-S7S0_xExbx38O1UVDKOpMfAxQliSDAiPxP86pW8N8k01-dPhV5zSudmm8S7No9s2CTuws4GyXD_kOmWX4lI9Btnm_yah-PZEp1_LtTKreU5SyzzRPedVvQ4NhjzLmb9l_WsfE_F0nKsZjuZfqpR5gXi-2CLUrDY3beZP73j2PRvVVG3SazrdySbGnpUcYk3YYqwr-GroCbZhGv3utpJt2xfJscfcIuLx_aq-DBo0nGBxBTSl-U5TLZGzeJwm5Li62UI'); mask-image: linear-gradient(to top, black, transparent);"></div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Clear previous errors
    document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));
    
    // Validation
    let isValid = true;
    
    if (!data.name) {
        document.getElementById('name-error').textContent = 'Nama lengkap wajib diisi';
        document.getElementById('name-error').classList.remove('hidden');
        isValid = false;
    }
    
    if (!validateEmail(data.email)) {
        document.getElementById('email-error').textContent = 'Email tidak valid';
        document.getElementById('email-error').classList.remove('hidden');
        isValid = false;
    }
    
    if (!validatePassword(data.password)) {
        document.getElementById('password-error').textContent = 'Password minimal 8 karakter';
        document.getElementById('password-error').classList.remove('hidden');
        isValid = false;
    }
    
    if (data.password !== data.password_confirmation) {
        document.getElementById('password_confirmation-error').textContent = 'Konfirmasi password tidak cocok';
        document.getElementById('password_confirmation-error').classList.remove('hidden');
        isValid = false;
    }
    
    if (!isValid) return;
    
    // Set loading state
    setButtonLoading(submitBtn, true);
    
    try {
        const response = await fetch('{{ route("register.post") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast('Registrasi berhasil! Mengalihkan...', 'success');
            setTimeout(() => {
                window.location.href = result.redirect || '{{ route("home") }}';
            }, 1000);
        } else {
            // Show validation errors
            if (result.errors) {
                Object.keys(result.errors).forEach(key => {
                    const errorEl = document.getElementById(`${key}-error`);
                    if (errorEl) {
                        errorEl.textContent = result.errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                });
            }
            showToast(result.message || 'Registrasi gagal. Periksa kembali data Anda.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <span>Daftar</span>
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            `;
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <span>Daftar</span>
            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
        `;
    }
});
</script>
@endpush