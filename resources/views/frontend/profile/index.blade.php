@extends('frontend.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<main class="flex-1 px-4 py-8 md:px-10 md:py-10 flex justify-center">
    <div class="w-full max-w-[1080px] grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar / Profile Summary -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-[#e5e7eb] p-6 flex flex-col items-center text-center">
                <div class="relative group cursor-pointer">
                    <!-- Avatar / Initials Placeholder -->
                    <div class="w-32 h-32 rounded-full bg-primary/10 flex items-center justify-center text-primary text-4xl font-bold mb-4 overflow-hidden border-4 border-white shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="absolute bottom-4 right-0 bg-white rounded-full p-2 shadow-md border border-[#e5e7eb] text-primary hover:text-primary/80 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                    </div>
                </div>
                <h1 class="text-[#111418] text-2xl font-bold mb-1">{{ Auth::user()->name }}</h1>
                <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary ring-1 ring-inset ring-primary/20">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
                <p class="text-[#60708a] text-sm mt-4">
                    Bergabung sejak {{ Auth::user()->created_at->isoFormat('MMMM YYYY') }}
                </p>
            </div>

            <!-- Navigation/Quick Links -->
            <div class="bg-white rounded-xl shadow-sm border border-[#e5e7eb] overflow-hidden hidden lg:block">
                <div class="flex flex-col">
                    <a class="flex items-center gap-3 px-6 py-4 bg-primary/5 border-l-4 border-primary text-primary font-medium" href="{{ route('profile') }}">
                        <span class="material-symbols-outlined">person</span>
                        Profil Saya
                    </a>
                    <a class="flex items-center gap-3 px-6 py-4 text-[#60708a] hover:bg-gray-50 transition-colors" href="{{ route('jadwal.index') }}">
                        <span class="material-symbols-outlined">event</span>
                        Jadwal Ibadah
                    </a>
                    <a class="flex items-center gap-3 px-6 py-4 text-[#60708a] hover:bg-gray-50 transition-colors" href="{{ route('pendaftaran.index') }}">
                        <span class="material-symbols-outlined">history</span>
                        Riwayat Pendaftaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Form Section -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <!-- Edit Profile Section -->
            <section class="bg-white rounded-xl shadow-sm border border-[#e5e7eb] overflow-hidden">
                <div class="px-6 py-5 border-b border-[#e5e7eb] flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#111418]">Informasi Pribadi</h3>
                        <p class="text-sm text-[#60708a]">Perbarui informasi kontak dan alamat Anda.</p>
                    </div>
                    <span class="material-symbols-outlined text-[#9ca3af]">edit_note</span>
                </div>
                
                <form id="profileForm" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Full Name -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-[#111418] text-sm font-medium">Nama Lengkap</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9ca3af] text-[20px]">badge</span>
                            <input 
                                name="name"
                                class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 pl-10 pr-4 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-colors" 
                                placeholder="Masukkan nama lengkap" 
                                type="text" 
                                value="{{ Auth::user()->name }}"
                                required
                            />
                        </div>
                        <span class="text-xs text-red-500 hidden" id="name-error"></span>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111418] text-sm font-medium">Alamat Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9ca3af] text-[20px]">mail</span>
                            <input 
                                name="email"
                                class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 pl-10 pr-4 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-colors" 
                                placeholder="nama@email.com" 
                                type="email" 
                                value="{{ Auth::user()->email }}"
                                required
                            />
                        </div>
                        <span class="text-xs text-red-500 hidden" id="email-error"></span>
                    </div>

                    <!-- Phone -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111418] text-sm font-medium">Nomor HP</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9ca3af] text-[20px]">call</span>
                            <input 
                                name="no_hp"
                                class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 pl-10 pr-4 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-colors" 
                                placeholder="08xx-xxxx-xxxx" 
                                type="tel" 
                                value="{{ Auth::user()->no_hp }}"
                            />
                        </div>
                        <span class="text-xs text-red-500 hidden" id="no_hp-error"></span>
                    </div>

                    <!-- Address -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-[#111418] text-sm font-medium">Alamat Domisili</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-3 text-[#9ca3af] text-[20px]">home_pin</span>
                            <textarea 
                                name="alamat"
                                class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] min-h-[100px] pl-10 pr-4 py-3 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm resize-none transition-colors" 
                                placeholder="Masukkan alamat lengkap..."
                            >{{ Auth::user()->alamat }}</textarea>
                        </div>
                        <span class="text-xs text-red-500 hidden" id="alamat-error"></span>
                    </div>

                    <div class="md:col-span-2 flex justify-end pt-2">
                        <button 
                            type="submit"
                            id="profileSubmitBtn"
                            class="flex items-center justify-center rounded-lg bg-primary text-white h-11 px-6 text-sm font-bold hover:bg-blue-600 transition-colors shadow-sm"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>

            <!-- Password Section -->
            <section class="bg-white rounded-xl shadow-sm border border-[#e5e7eb] overflow-hidden">
                <div class="px-6 py-5 border-b border-[#e5e7eb] flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#111418]">Keamanan Akun</h3>
                        <p class="text-sm text-[#60708a]">Perbarui kata sandi untuk menjaga keamanan akun Anda.</p>
                    </div>
                    <span class="material-symbols-outlined text-[#9ca3af]">lock_reset</span>
                </div>
                
                <form id="passwordForm" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Password -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-[#111418] text-sm font-medium">Password Saat Ini</label>
                        <input 
                            name="current_password"
                            class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 px-4 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-colors" 
                            placeholder="Masukkan password lama" 
                            type="password"
                            required
                        />
                        <span class="text-xs text-red-500 hidden" id="current_password-error"></span>
                    </div>

                    <!-- New Password -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111418] text-sm font-medium">Password Baru</label>
                        <input 
                            name="password"
                            class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 px-4 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-colors" 
                            placeholder="Minimal 8 karakter" 
                            type="password"
                            required
                        />
                        <span class="text-xs text-red-500 hidden" id="password-error"></span>
                    </div>

                    <!-- Confirm Password -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111418] text-sm font-medium">Konfirmasi Password Baru</label>
                        <input 
                            name="password_confirmation"
                            class="w-full rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 px-4 placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-colors" 
                            placeholder="Ulangi password baru" 
                            type="password"
                            required
                        />
                        <span class="text-xs text-red-500 hidden" id="password_confirmation-error"></span>
                    </div>

                    <div class="md:col-span-2 flex justify-end pt-2">
                        <button 
                            type="submit"
                            id="passwordSubmitBtn"
                            class="flex items-center justify-center rounded-lg border border-[#dbdfe6] bg-white text-[#111418] h-11 px-6 text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm"
                        >
                            Update Password
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Update Profile
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('profileSubmitBtn');
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Clear previous errors
    document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));
    
    // Set loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
    
    try {
        const response = await fetch('{{ route("profile.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast(result.message, 'success');
            setTimeout(() => {
                window.location.reload();
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
            showToast(result.message || 'Gagal memperbarui profil', 'error');
            
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan Perubahan';
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Simpan Perubahan';
    }
});

// Update Password
document.getElementById('passwordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('passwordSubmitBtn');
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Clear previous errors
    document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));
    
    // Set loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memperbarui...';
    
    try {
        const response = await fetch('{{ route("profile.update-password") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast(result.message, 'success');
            this.reset(); // Clear form
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update Password';
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
            showToast(result.message || 'Gagal memperbarui password', 'error');
            
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update Password';
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Update Password';
    }
});
</script>
@endpush