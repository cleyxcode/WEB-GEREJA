@extends('frontend.layouts.app')

@section('title', 'Galeri Sakramen')

@section('content')
<main class="flex-grow w-full max-w-[1440px] mx-auto px-6 md:px-10 lg:px-40 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-neutral-900 mb-2">Galeri Sakramen</h1>
        <p class="text-neutral-500 text-lg">Dokumentasi foto layanan gerejawi yang telah disetujui.</p>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('galeri.index') }}"
          class="bg-white rounded-xl border border-neutral-200 shadow-sm px-6 py-4 mb-8 flex flex-wrap items-center gap-4">

        {{-- Search --}}
        <div class="relative flex-1 min-w-[200px]">
            <span class="material-symbols-outlined absolute left-3 top-2.5 text-neutral-400 text-[20px]">search</span>
            <input
                name="search"
                value="{{ request('search') }}"
                type="text"
                placeholder="Cari nama..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-200 bg-neutral-50 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
            />
        </div>

        {{-- Filter Jenis --}}
        <div class="flex items-center gap-2 flex-wrap">
            @php
                $jenisFilter = [
                    ''       => ['label' => 'Semua',            'icon' => 'filter_list'],
                    'baptis' => ['label' => 'Baptis Kudus',     'icon' => 'child_care'],
                    'sidi'   => ['label' => 'Sidi',             'icon' => 'diversity_3'],
                    'nikah'  => ['label' => 'Pemberkatan Nikah','icon' => 'volunteer_activism'],
                ];
            @endphp
            @foreach($jenisFilter as $val => $item)
            <a href="{{ route('galeri.index', array_merge(request()->except('jenis', 'page'), $val ? ['jenis' => $val] : [])) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium transition-all
                      {{ request('jenis') === $val || (request('jenis') === null && $val === '')
                         ? 'bg-primary text-white shadow-sm'
                         : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                <span class="material-symbols-outlined text-[16px]">{{ $item['icon'] }}</span>
                {{ $item['label'] }}
            </a>
            @endforeach
        </div>

        {{-- Submit Search --}}
        <button type="submit"
            class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-all">
            Cari
        </button>
    </form>

    {{-- Grid Galeri --}}
    @if($galeri->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($galeri as $item)
        <div class="bg-white rounded-xl border border-neutral-200 shadow-sm overflow-hidden group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer"
             onclick="bukaFoto('{{ Storage::url($item->foto) }}', '{{ $item->nama }}', '{{ $item->jenis }}', '{{ $item->tanggal_daftar->isoFormat('DD MMMM YYYY') }}')">

            {{-- Foto --}}
            <div class="relative overflow-hidden aspect-square bg-neutral-100">
                <img src="{{ Storage::url($item->foto) }}"
                     alt="Foto {{ $item->nama }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                {{-- Badge Jenis --}}
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold backdrop-blur-sm
                        {{ $item->jenis == 'baptis' ? 'bg-yellow-100/90 text-yellow-800' : ($item->jenis == 'sidi' ? 'bg-blue-100/90 text-blue-800' : 'bg-pink-100/90 text-pink-800') }}">
                        <span class="material-symbols-outlined text-[13px]">
                            {{ $item->jenis == 'baptis' ? 'child_care' : ($item->jenis == 'sidi' ? 'diversity_3' : 'volunteer_activism') }}
                        </span>
                        {{ $item->jenis == 'baptis' ? 'Baptis' : ($item->jenis == 'sidi' ? 'Sidi' : 'Nikah') }}
                    </span>
                </div>

                {{-- Overlay zoom icon --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-[40px] opacity-0 group-hover:opacity-100 transition-opacity drop-shadow">zoom_in</span>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-4">
                <p class="text-sm font-bold text-neutral-900 truncate">{{ $item->nama }}</p>
                <p class="text-xs text-neutral-500 mt-0.5">{{ $item->tanggal_daftar->isoFormat('DD MMM YYYY') }}</p>
                @if($item->catatan)
                <p class="text-xs text-neutral-400 mt-2 line-clamp-2">{{ $item->catatan }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10 flex justify-center">
        {{ $galeri->appends(request()->query())->links('pagination::tailwind') }}
    </div>

    @else
    {{-- Empty State --}}
    <div class="bg-white rounded-xl border border-neutral-200 shadow-sm flex flex-col items-center justify-center py-24 px-6 text-center">
        <div class="w-20 h-20 rounded-full bg-neutral-100 flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-4xl text-neutral-400">photo_library</span>
        </div>
        <h3 class="text-lg font-bold text-neutral-900 mb-1">Belum Ada Foto</h3>
        <p class="text-sm text-neutral-500">
            @if(request('jenis') || request('search'))
                Tidak ada hasil untuk filter yang dipilih.
                <a href="{{ route('galeri.index') }}" class="text-primary hover:underline font-medium ml-1">Reset filter</a>
            @else
                Belum ada foto dari layanan yang telah disetujui.
            @endif
        </p>
    </div>
    @endif

</main>

{{-- Modal Foto --}}
<div id="modal-galeri"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4"
     onclick="tutupModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden" onclick="event.stopPropagation()">
        {{-- Header Modal --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-200">
            <div>
                <h3 id="modal-nama" class="font-bold text-neutral-900 text-lg"></h3>
                <div class="flex items-center gap-2 mt-0.5">
                    <span id="modal-badge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium"></span>
                    <span id="modal-tanggal" class="text-xs text-neutral-500"></span>
                </div>
            </div>
            <button onclick="tutupModal()" class="text-neutral-400 hover:text-neutral-700 transition-colors ml-4 shrink-0">
                <span class="material-symbols-outlined text-[28px]">close</span>
            </button>
        </div>
        {{-- Foto --}}
        <div class="p-5 bg-neutral-50">
            <img id="modal-foto" src="" alt="" class="w-full rounded-xl object-contain max-h-[65vh]">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const jenisLabel = {
    baptis: { label: 'Baptis Kudus',      color: 'bg-yellow-100 text-yellow-800' },
    sidi:   { label: 'Sidi (Peneguhan)',   color: 'bg-blue-100 text-blue-800'    },
    nikah:  { label: 'Pemberkatan Nikah',  color: 'bg-pink-100 text-pink-800'    },
};

function bukaFoto(url, nama, jenis, tanggal) {
    document.getElementById('modal-foto').src = url;
    document.getElementById('modal-nama').textContent = nama;
    document.getElementById('modal-tanggal').textContent = tanggal;

    const badge = document.getElementById('modal-badge');
    const info = jenisLabel[jenis] || { label: jenis, color: 'bg-neutral-100 text-neutral-700' };
    badge.textContent = info.label;
    badge.className = `inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium ${info.color}`;

    const modal = document.getElementById('modal-galeri');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function tutupModal(e) {
    if (e && e.target !== document.getElementById('modal-galeri')) return;
    const modal = document.getElementById('modal-galeri');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Tutup dengan tombol ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('modal-galeri');
        if (!modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }
});
</script>
@endpush