@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
<main class="flex-grow w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    {{-- ===== HERO ===== --}}
    <section class="relative w-full rounded-2xl overflow-hidden shadow-xl min-h-[480px] flex items-center group">
        <div class="absolute inset-0 z-0 transition-transform duration-700 group-hover:scale-105"
             style="background-image: url('{{ asset('images/gereja.jpeg') }}'); background-size: cover; background-position: center;">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent z-10"></div>
        <div class="relative z-20 max-w-2xl px-8 md:px-12 py-12 flex flex-col gap-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-semibold w-fit">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                Melayani dengan Kasih dan Sukacita
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                Selamat Datang di<br/>
                <span class="text-blue-300">Website Jemaat GPM Masohi</span>
            </h2>
            <p class="text-lg text-gray-200 font-medium max-w-lg leading-relaxed">
                Bergabunglah bersama kami dalam persekutuan yang hangat. Temukan jadwal ibadah, berita terbaru, dan informasi pelayanan gereja GPM Masohi.
            </p>
            <div class="flex flex-wrap gap-4 mt-2">
                <a href="{{ route('jadwal.index') }}"
                   class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-lg shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <span class="material-symbols-outlined">calendar_month</span>
                    Lihat Jadwal
                </a>
                <button class="px-6 py-3 bg-white hover:bg-gray-50 text-[#111418] font-bold rounded-lg shadow-md transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <span class="material-symbols-outlined">info</span>
                    Tentang Kami
                </button>
            </div>
        </div>
    </section>

    {{-- ===== JADWAL IBADAH TERDEKAT ===== --}}
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-[#111418] flex items-center gap-2">
                <span class="w-1.5 h-8 bg-primary rounded-full"></span>
                Jadwal Ibadah Terdekat
            </h2>
            <a class="text-sm font-bold text-primary hover:text-primary-dark flex items-center gap-1"
               href="{{ route('jadwal.index') }}">
                Lihat Semua <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>

        @if($jadwalTerdekat->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($jadwalTerdekat as $index => $jadwal)
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                <div class="h-2 {{ $index == 0 ? 'bg-primary' : ($index == 1 ? 'bg-secondary' : 'bg-blue-400') }}"></div>
                <div class="p-5 flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wide
                            {{ $index == 0 ? 'bg-primary/10 text-primary' : ($index == 1 ? 'bg-secondary/10 text-secondary' : 'bg-blue-100 text-blue-700') }}">
                            Ibadah
                        </span>
                        <span class="flex items-center text-gray-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">event_available</span>
                        </span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#111418] mb-1">
                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMM YYYY') }}
                        </h3>
                        <div class="flex items-center gap-2 text-gray-600 mb-3">
                            <span class="material-symbols-outlined text-lg">schedule</span>
                            <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <span class="material-symbols-outlined text-lg">location_on</span>
                            <span class="text-sm">{{ $jadwal->tempat }}</span>
                        </div>
                    </div>
                    <div class="pt-4 mt-auto border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                {{ strtoupper(substr($jadwal->petugas_ibadah, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Petugas</p>
                                <p class="text-sm font-semibold text-[#111418]">{{ $jadwal->petugas_ibadah }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-gray-50 rounded-xl p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4 block">event_busy</span>
            <p class="text-gray-500">Belum ada jadwal ibadah mendatang</p>
        </div>
        @endif
    </section>

    {{-- ===== BERITA & KEGIATAN ===== --}}
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-[#111418] flex items-center gap-2">
                <span class="w-1.5 h-8 bg-primary rounded-full"></span>
                Berita & Kegiatan Terbaru
            </h2>
            <a class="text-sm font-bold text-primary hover:text-primary-dark flex items-center gap-1"
               href="{{ route('berita.index') }}">
                Lihat Berita Lainnya <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>

        @if($beritaTerbaru->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($beritaTerbaru as $berita)
            <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all flex flex-col h-full border border-gray-100">
                <div class="relative h-48 overflow-hidden group">
                    @if($berita->gambar)
                        <img alt="{{ $berita->judul }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             src="{{ asset('storage/' . $berita->gambar) }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-gray-300">article</span>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-md text-xs font-bold text-primary shadow-sm">
                        Berita
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <div class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                        {{ $berita->created_at->isoFormat('D MMM YYYY') }}
                    </div>
                    <h3 class="text-lg font-bold text-[#111418] mb-2 leading-tight hover:text-primary transition-colors cursor-pointer">
                        {{ $berita->judul }}
                    </h3>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4 flex-1">
                        {{ strip_tags($berita->isi) }}
                    </p>
                    <a class="text-sm font-bold text-primary hover:text-primary-dark inline-flex items-center gap-1 mt-auto"
                       href="{{ route('berita.show', $berita->id) }}">
                        Baca Selengkapnya <span class="material-symbols-outlined text-lg">arrow_right_alt</span>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="bg-gray-50 rounded-xl p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4 block">article</span>
            <p class="text-gray-500">Belum ada berita terbaru</p>
        </div>
        @endif
    </section>

    {{-- ===== GALERI SAKRAMEN ===== --}}
    @if($galeriBeranda->count() > 0)
    <section class="space-y-6 pb-8">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-[#111418] flex items-center gap-2">
                <span class="w-1.5 h-8 bg-primary rounded-full"></span>
                Galeri Sakramen
            </h2>
            <a class="text-sm font-bold text-primary hover:text-primary-dark flex items-center gap-1"
               href="{{ route('galeri.index') }}">
                Lihat Semua <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($galeriBeranda as $item)
            <div class="group relative aspect-square rounded-xl overflow-hidden shadow-sm cursor-pointer border border-gray-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200"
                 onclick="bukaFotoBeranda(
                     '{{ Storage::url($item->foto) }}',
                     '{{ addslashes($item->nama) }}',
                     '{{ $item->jenis }}',
                     '{{ $item->tanggal_daftar->isoFormat('DD MMMM YYYY') }}'
                 )">

                {{-- Foto --}}
                <img src="{{ Storage::url($item->foto) }}"
                     alt="{{ $item->nama }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-end p-3">
                    <p class="text-white text-xs font-bold truncate">{{ $item->nama }}</p>
                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold w-fit
                        {{ $item->jenis == 'baptis' ? 'bg-yellow-400/90 text-yellow-900' : ($item->jenis == 'sidi' ? 'bg-blue-400/90 text-blue-900' : 'bg-pink-400/90 text-pink-900') }}">
                        {{ $item->jenis == 'baptis' ? 'Baptis' : ($item->jenis == 'sidi' ? 'Sidi' : 'Nikah') }}
                    </span>
                </div>

                {{-- Icon zoom --}}
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-white text-[18px] drop-shadow">zoom_in</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</main>

{{-- ===== MODAL FOTO GALERI ===== --}}
<div id="modal-foto-beranda"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4"
     onclick="tutupModalBeranda(event)">
    <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full overflow-hidden"
         onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-200">
            <div>
                <h3 id="modal-beranda-nama" class="font-bold text-neutral-900 text-lg"></h3>
                <div class="flex items-center gap-2 mt-0.5">
                    <span id="modal-beranda-badge" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"></span>
                    <span id="modal-beranda-tanggal" class="text-xs text-neutral-500"></span>
                </div>
            </div>
            <button onclick="tutupModalBeranda()"
                    class="text-neutral-400 hover:text-neutral-700 transition-colors ml-4 shrink-0">
                <span class="material-symbols-outlined text-[28px]">close</span>
            </button>
        </div>
        <div class="p-5 bg-neutral-50">
            <img id="modal-beranda-foto" src="" alt=""
                 class="w-full rounded-xl object-contain max-h-[65vh]">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const jenisInfoBeranda = {
    baptis: { label: 'Baptis Kudus',      color: 'bg-yellow-100 text-yellow-800' },
    sidi:   { label: 'Sidi (Peneguhan)',  color: 'bg-blue-100 text-blue-800'    },
    nikah:  { label: 'Pemberkatan Nikah', color: 'bg-pink-100 text-pink-800'    },
};

function bukaFotoBeranda(url, nama, jenis, tanggal) {
    document.getElementById('modal-beranda-foto').src = url;
    document.getElementById('modal-beranda-nama').textContent = nama;
    document.getElementById('modal-beranda-tanggal').textContent = tanggal;

    const badge  = document.getElementById('modal-beranda-badge');
    const info   = jenisInfoBeranda[jenis] || { label: jenis, color: 'bg-neutral-100 text-neutral-700' };
    badge.textContent = info.label;
    badge.className   = `inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${info.color}`;

    const modal = document.getElementById('modal-foto-beranda');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function tutupModalBeranda(e) {
    if (e && e.currentTarget !== e.target) return;
    const modal = document.getElementById('modal-foto-beranda');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('modal-foto-beranda');
        if (!modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }
});
</script>
@endpush