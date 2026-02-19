<nav x-data="{ mobileOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
     :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg shadow-black/5' : 'bg-white'"
     class="sticky top-0 z-50 w-full border-b border-gray-100/80 transition-all duration-300">

    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[68px]">

            {{-- ===== LOGO ===== --}}
<a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
    <div class="relative flex items-center justify-center w-9 h-9">
        <div class="absolute inset-0 bg-primary rounded-xl rotate-6 opacity-20 group-hover:rotate-12 transition-transform duration-300"></div>
        <div class="relative bg-primary/10 rounded-xl w-full h-full flex items-center justify-center overflow-hidden">
            <img src="{{ asset('images/logoupdate.png') }}" alt="Logo" class="w-7 h-7 object-contain">
        </div>
    </div>
    <div class="flex flex-col leading-none">
        <span class="text-[15px] font-black tracking-tight text-gray-900">Jemaat Masohi</span>
        <span class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">Sistem Informasi</span>
    </div>
</a>

            {{-- ===== DESKTOP MENU ===== --}}
            <nav class="hidden lg:flex items-center gap-1">
                @php
                    $navItems = [
                        ['route' => 'home',             'label' => 'Beranda',          'icon' => 'home',            'match' => 'home'],
                        ['route' => 'jadwal.index',     'label' => 'Jadwal',           'icon' => 'calendar_month',  'match' => 'jadwal.*'],
                        ['route' => 'berita.index',     'label' => 'Berita',           'icon' => 'newspaper',       'match' => 'berita.*'],
                        ['route' => 'pendaftaran.index','label' => 'Pendaftaran',      'icon' => 'app_registration', 'match' => 'pendaftaran.*'],
                        ['route' => 'keuangan.index',   'label' => 'Keuangan',         'icon' => 'account_balance', 'match' => 'keuangan.*'],
                        ['route' => 'saran.create',     'label' => 'Kotak Saran',      'icon' => 'mail',            'match' => 'saran.*'],
                    ];
                @endphp

                @foreach($navItems as $item)
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="relative flex items-center gap-1.5 px-3 py-2 rounded-lg text-[13.5px] font-medium transition-all duration-200 group
                          {{ $active
                             ? 'text-primary bg-primary/8'
                             : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:scale-110"
                          style="font-variation-settings:'FILL' {{ $active ? '1' : '0' }}">
                        {{ $item['icon'] }}
                    </span>
                    {{ $item['label'] }}
                    @if($active)
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-4 h-0.5 bg-primary rounded-full"></span>
                    @endif
                </a>
                @endforeach
            </nav>

            {{-- ===== RIGHT ACTIONS ===== --}}
            <div class="hidden md:flex items-center gap-2">

                {{-- Profile Button --}}
                <a href="{{ route('profile') }}"
                   class="flex items-center gap-2.5 pl-2 pr-4 py-2 rounded-xl text-sm font-semibold text-gray-700
                          hover:bg-gray-50 border border-transparent hover:border-gray-200
                          transition-all duration-200 group">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary to-blue-400 flex items-center justify-center text-white text-xs font-black shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-[12px] text-gray-400 font-normal">Halo,</span>
                        <span class="text-[13px] text-gray-800 font-semibold">{{ Str::limit(Auth::user()->name, 14) }}</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-gray-400 group-hover:text-gray-600 ml-1">expand_more</span>
                </a>

                {{-- Divider --}}
                <div class="w-px h-6 bg-gray-200"></div>

                {{-- Logout --}}
                <button onclick="handleLogout()"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-[13px] font-semibold
                               text-red-500 hover:text-red-600 hover:bg-red-50
                               border border-transparent hover:border-red-100
                               transition-all duration-200 group">
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-0.5 transition-transform">logout</span>
                    Keluar
                </button>
            </div>

            {{-- ===== MOBILE BUTTON ===== --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                <span class="material-symbols-outlined" x-text="mobileOpen ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    {{-- ===== MOBILE MENU ===== --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-gray-100 bg-white/98 backdrop-blur-md shadow-xl shadow-black/5">

        {{-- Mobile Nav Items --}}
        <div class="px-4 pt-3 pb-2 grid grid-cols-3 gap-2">
            @foreach($navItems as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex flex-col items-center gap-1.5 px-2 py-3 rounded-xl text-center transition-all
                      {{ $active ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <span class="material-symbols-outlined text-[22px]"
                      style="font-variation-settings:'FILL' {{ $active ? '1' : '0' }}">
                    {{ $item['icon'] }}
                </span>
                <span class="text-[11px] font-semibold leading-tight">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </div>

        {{-- Mobile Profile & Logout --}}
        <div class="px-4 pb-4 pt-2 border-t border-gray-100 flex items-center justify-between gap-3">
            <a href="{{ route('profile') }}"
               class="flex items-center gap-3 flex-1 px-4 py-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-blue-400 flex items-center justify-center text-white text-sm font-black">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-[11px] text-gray-400">Login sebagai</p>
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                </div>
            </a>
            <button onclick="handleLogout()"
                    class="flex items-center gap-2 px-4 py-3 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 font-semibold text-sm transition-colors shrink-0">
                <span class="material-symbols-outlined text-[20px]">logout</span>
                Keluar
            </button>
        </div>
    </div>
</nav>

@push('scripts')
<script>
async function handleLogout() {
    if (!confirm('Apakah Anda yakin ingin keluar?')) return;
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
            showToast('Sampai jumpa! 👋', 'success');
            setTimeout(() => { window.location.href = data.redirect || '{{ route("login") }}'; }, 1000);
        }
    } catch (e) {
        showToast('Terjadi kesalahan', 'error');
    }
}
</script>
@endpush