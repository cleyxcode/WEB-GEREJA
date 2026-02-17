<!-- Sticky Navbar -->
<header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-sm border-b border-[#f0f2f5] shadow-sm">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center size-8 bg-primary/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined">church</span>
                </div>
                <h1 class="text-lg font-bold tracking-tight text-[#111418]">Gereja Bethesda</h1>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden lg:flex items-center gap-6">
                <a class="text-sm font-medium {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors" href="{{ route('home') }}">
                    Beranda
                </a>
                <a class="text-sm font-medium {{ request()->routeIs('jadwal.*') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors" href="{{ route('jadwal.index') }}">
                    Jadwal Ibadah
                </a>
                <a class="text-sm font-medium {{ request()->routeIs('berita.*') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors" href="{{ route('berita.index') }}">
                    Berita
                </a>
                <a class="text-sm font-medium {{ request()->routeIs('pendaftaran.*') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors" href="{{ route('pendaftaran.index') }}">
                    Pendaftaran
                </a>
                <a class="text-sm font-medium {{ request()->routeIs('keuangan.*') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors" href="{{ route('keuangan.index') }}">
                    Laporan Keuangan
                </a>
                <a class="text-sm font-medium {{ request()->routeIs('saran.*') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors" href="{{ route('saran.create') }}">
                    Kirim Saran
                </a>
            </nav>

            <!-- Actions -->
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('profile') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <button onclick="handleLogout()" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-danger bg-danger/10 hover:bg-danger/20 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span>Logout</span>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-gray-100 bg-white">
        <nav class="px-4 py-4 space-y-2">
            <a class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : 'text-gray-600' }} rounded-lg hover:bg-gray-50" href="{{ route('home') }}">
                Beranda
            </a>
            <a class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('jadwal.*') ? 'text-primary bg-primary/10' : 'text-gray-600' }} rounded-lg hover:bg-gray-50" href="{{ route('jadwal.index') }}">
                Jadwal Ibadah
            </a>
            <a class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('berita.*') ? 'text-primary bg-primary/10' : 'text-gray-600' }} rounded-lg hover:bg-gray-50" href="{{ route('berita.index') }}">
                Berita
            </a>
            <a class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('pendaftaran.*') ? 'text-primary bg-primary/10' : 'text-gray-600' }} rounded-lg hover:bg-gray-50" href="{{ route('pendaftaran.index') }}">
                Pendaftaran
            </a>
            <a class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('keuangan.*') ? 'text-primary bg-primary/10' : 'text-gray-600' }} rounded-lg hover:bg-gray-50" href="{{ route('keuangan.index') }}">
                Laporan Keuangan
            </a>
            <a class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('saran.*') ? 'text-primary bg-primary/10' : 'text-gray-600' }} rounded-lg hover:bg-gray-50" href="{{ route('saran.create') }}">
                Kirim Saran
            </a>
            <div class="pt-2 border-t border-gray-100">
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">
                    Profile ({{ Auth::user()->name }})
                </a>
                <button onclick="handleLogout()" class="w-full text-left block px-4 py-2 text-sm font-medium text-danger rounded-lg hover:bg-danger/10">
                    Logout
                </button>
            </div>
        </nav>
    </div>
</header>

@push('scripts')
<script>
// Mobile Menu Toggle
document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
});

// Logout Handler
async function handleLogout() {
    if (!confirm('Apakah Anda yakin ingin keluar?')) {
        return;
    }
    
    try {
        const response = await fetch('{{ route("logout") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (response.ok) {
            showToast('Logout berhasil', 'success');
            setTimeout(() => {
                window.location.href = data.redirect || '{{ route("login") }}';
            }, 1000);
        }
    } catch (error) {
        showToast('Terjadi kesalahan', 'error');
    }
}
</script>
@endpush