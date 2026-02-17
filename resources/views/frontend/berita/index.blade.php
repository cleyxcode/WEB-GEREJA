@extends('frontend.layouts.app')

@section('title', 'Berita & Pengumuman')

@section('content')
<main class="flex-grow w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Page Header & Search -->
    <section class="mb-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-[#60708a]">
                    <a class="hover:text-primary" href="{{ route('home') }}">Beranda</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-[#111418]">Berita</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-[#111418]">Berita & Pengumuman</h1>
                <p class="text-lg text-[#60708a] leading-relaxed">
                    Dapatkan informasi terkini seputar pelayanan, kegiatan ibadah, dan pengumuman resmi Gereja Bethesda.
                </p>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <form method="GET" action="{{ route('berita.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-[#f0f2f5] flex flex-col md:flex-row gap-4 items-center">
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-[#60708a]">search</span>
                </div>
                <input 
                    name="search"
                    value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm transition-shadow" 
                    placeholder="Cari berita atau pengumuman..." 
                    type="text"
                />
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="whitespace-nowrap px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-dark transition-colors">
                    Cari
                </button>
                @if(request('search'))
                <a href="{{ route('berita.index') }}" class="whitespace-nowrap px-5 py-2 bg-[#f0f2f5] text-[#60708a] hover:bg-gray-200 text-sm font-medium rounded-lg transition-colors">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </section>

    <!-- News Grid -->
    @if($beritaList->count() > 0)
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        @foreach($beritaList as $berita)
        <article class="flex flex-col bg-white rounded-2xl overflow-hidden border border-[#f0f2f5] hover:shadow-lg transition-all duration-300 group cursor-pointer h-full">
            <div class="relative h-56 overflow-hidden">
                @if($berita->gambar)
                    <img 
                        alt="{{ $berita->judul }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                        src="{{ asset('storage/' . $berita->gambar) }}"
                    />
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-blue-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-primary/30">article</span>
                    </div>
                @endif
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary shadow-sm">
                    Berita
                </div>
            </div>
            <div class="flex flex-col flex-1 p-6">
                <div class="flex items-center gap-2 text-sm text-[#60708a] mb-3">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>{{ $berita->created_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
                <h3 class="text-xl font-bold text-[#111418] mb-3 leading-tight group-hover:text-primary transition-colors">
                    {{ $berita->judul }}
                </h3>
                <p class="text-[#60708a] text-sm leading-relaxed mb-6 line-clamp-3">
                    {{ strip_tags($berita->isi) }}
                </p>
                <div class="mt-auto pt-4 border-t border-[#f0f2f5] flex items-center justify-between">
                    <a href="{{ route('berita.show', $berita->id) }}" class="text-sm font-semibold text-primary group-hover:underline decoration-2 underline-offset-4">
                        Baca Selengkapnya
                    </a>
                    <span class="material-symbols-outlined text-primary text-sm transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </div>
        </article>
        @endforeach
    </section>

    <!-- Pagination -->
    <div class="flex items-center justify-center gap-2 mb-12">
        {{ $beritaList->links('frontend.pagination') }}
    </div>

    @else
    <!-- Empty State -->
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="size-20 bg-[#f0f2f5] rounded-full flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-4xl text-[#60708a]">article</span>
        </div>
        <h3 class="text-2xl font-bold text-[#111418] mb-3">Belum Ada Berita</h3>
        <p class="text-[#60708a] max-w-md mb-6">
            @if(request('search'))
                Tidak ada berita yang cocok dengan pencarian "{{ request('search') }}".
            @else
                Belum ada berita yang dipublikasikan saat ini.
            @endif
        </p>
        @if(request('search'))
        <a href="{{ route('berita.index') }}" class="px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-dark transition-colors">
            Lihat Semua Berita
        </a>
        @endif
    </div>
    @endif
</main>
@endsection