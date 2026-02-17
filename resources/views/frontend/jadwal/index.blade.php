@extends('frontend.layouts.app')

@section('title', 'Jadwal Ibadah')

@section('content')
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-20 xl:px-40">
    <div class="flex flex-col max-w-[1200px] w-full flex-1 gap-8">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 px-1">
            <a class="text-[#637588] text-sm font-medium leading-normal hover:underline" href="{{ route('home') }}">Beranda</a>
            <span class="text-[#637588] text-sm font-medium leading-normal">/</span>
            <span class="text-[#111418] text-sm font-medium leading-normal">Jadwal Ibadah</span>
        </div>

        <!-- Page Title & Hero Filters -->
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2">
                <h1 class="text-[#111418] text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">Jadwal Ibadah Mendatang</h1>
                <p class="text-[#637588] text-base font-normal leading-normal max-w-2xl">
                    Temukan informasi lengkap mengenai jadwal, lokasi, dan petugas pelayanan untuk ibadah minggu ini dan bulan mendatang.
                </p>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('jadwal.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-[#e5e7eb] flex flex-col md:flex-row gap-4 items-end">
                <label class="flex flex-col w-full md:w-1/4 gap-1.5">
                    <span class="text-[#111418] text-sm font-semibold leading-normal">Bulan</span>
                    <div class="relative">
                        <select name="bulan" class="form-select w-full appearance-none rounded-lg border border-[#d1d5db] bg-white h-11 px-3 py-2 text-sm text-[#111418] focus:border-primary focus:ring-1 focus:ring-primary outline-none cursor-pointer">
                            <option value="">Semua Bulan</option>
                            @foreach($months as $month)
                                <option value="{{ $month['value'] }}" {{ request('bulan') == $month['value'] ? 'selected' : '' }}>
                                    {{ $month['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-[#637588] pointer-events-none text-xl">expand_more</span>
                    </div>
                </label>

                <label class="flex flex-col w-full md:flex-1 gap-1.5">
                    <span class="text-[#111418] text-sm font-semibold leading-normal">Cari</span>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#637588] text-xl">search</span>
                        <input 
                            name="search" 
                            value="{{ request('search') }}"
                            class="form-input w-full rounded-lg border border-[#d1d5db] bg-white h-11 pl-10 pr-3 py-2 text-sm text-[#111418] placeholder:text-[#9ca3af] focus:border-primary focus:ring-1 focus:ring-primary outline-none" 
                            placeholder="Cari nama petugas, tema ibadah, atau lokasi..." 
                            type="text"
                        />
                    </div>
                </label>

                <button type="submit" class="h-11 px-6 bg-primary text-white font-medium text-sm rounded-lg hover:bg-primary-dark transition-colors">
                    Terapkan Filter
                </button>

                @if(request('bulan') || request('search'))
                <a href="{{ route('jadwal.index') }}" class="h-11 px-6 bg-white border border-[#d1d5db] text-[#111418] font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    Reset Filter
                </a>
                @endif
            </form>
        </div>

        <!-- Featured Card (Upcoming) -->
        @if($jadwalTerdekat)
        <div class="relative overflow-hidden rounded-xl bg-primary text-white shadow-md">
            <div class="absolute inset-0 bg-cover bg-center opacity-20 mix-blend-overlay" 
                 style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDIn63uoGarzfGaSE9pohLPCKPQEKwNL06ndlZju33aNlCVgeaPBkvIKHEYxqUdse2i6dQqHsxRLG0zAWSCjOLOLJyOWg6-crVSn8mn1VQCa8FmLuttukuIOjQu8of1CnjvU064k5av3DocJXA84iFslq9cDawzRuEz7y0CKmUTRI8rPqA50v7cIAE_6rkhftU0FcPVU8F9fmNZNoNfZS6VxbuLzptNuzPAbolYPyW7UzyxXFsIj3K3baxf9IFSKdxPqbM68pyM5gzQ');">
            </div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between p-6 md:p-8 gap-6">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-blue-100 text-sm font-semibold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-lg">event_upcoming</span>
                        Ibadah Terdekat
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold">
                        {{ $jadwalTerdekat->tanggal->isoFormat('dddd, D MMMM YYYY') }}
                    </h3>
                    <p class="text-blue-50 text-lg flex items-center gap-2">
                        <span class="material-symbols-outlined">schedule</span> 
                        {{ \Carbon\Carbon::parse($jadwalTerdekat->waktu)->format('H:i') }} WIB
                        <span class="mx-2">•</span>
                        <span class="material-symbols-outlined">location_on</span> 
                        {{ $jadwalTerdekat->tempat }}
                    </p>
                </div>
                @if($jadwalTerdekat->liturgi_file)
                <a href="{{ route('jadwal.download-liturgi', $jadwalTerdekat->id) }}" class="shrink-0 bg-white text-primary hover:bg-blue-50 transition-colors font-bold text-sm px-6 py-3 rounded-lg shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">description</span>
                    Lihat Liturgi
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Grid Cards -->
        @if($jadwalList->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
            @foreach($jadwalList as $jadwal)
            <div class="flex flex-col bg-white rounded-xl shadow border border-[#f0f2f5] hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
                <div class="h-2 bg-primary w-full"></div>
                <div class="p-5 flex flex-col gap-4 flex-1">
                    <div class="flex justify-between items-start">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-primary uppercase tracking-wide">Ibadah</span>
                            <h3 class="text-xl font-bold text-[#111418] mt-1">
                                {{ $jadwal->tanggal->format('d M Y') }}
                            </h3>
                        </div>
                        <div class="bg-blue-50 text-primary p-2 rounded-lg">
                            <span class="material-symbols-outlined block">calendar_month</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 text-sm text-[#4b5563]">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#9ca3af]">schedule</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#9ca3af]">location_on</span>
                            <span class="font-medium">{{ $jadwal->tempat }}</span>
                        </div>
                    </div>

                    <hr class="border-[#f0f2f5]"/>

                    <div class="flex flex-col gap-3 flex-1">
                        <p class="text-xs font-bold text-[#9ca3af] uppercase tracking-wider">Petugas Pelayanan</p>
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-full bg-gray-100 flex items-center justify-center text-[#6b7280] font-bold text-xs">
                                {{ strtoupper(substr($jadwal->petugas_ibadah, 0, 2)) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-[#6b7280]">Petugas</span>
                                <span class="text-sm font-semibold text-[#111418]">{{ $jadwal->petugas_ibadah }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        @if($jadwal->liturgi_file || $jadwal->liturgi_text)
                        <a href="{{ route('jadwal.show', $jadwal->id) }}" class="w-full h-10 bg-primary/10 hover:bg-primary text-primary hover:text-white transition-all font-bold text-sm rounded-lg flex items-center justify-center gap-2 group-hover:bg-primary group-hover:text-white">
                            <span>Lihat Detail</span>
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </a>
                        @else
                        <button disabled class="w-full h-10 bg-gray-100 text-gray-400 font-bold text-sm rounded-lg flex items-center justify-center gap-2 cursor-not-allowed">
                            <span>Liturgi Tidak Tersedia</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center gap-2 pb-10">
            {{ $jadwalList->links('pagination::custom') }}
        </div>
        @else
        <div class="flex flex-col bg-white rounded-xl shadow border border-[#f0f2f5] p-12 items-center justify-center text-center min-h-[400px]">
            <div class="size-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                <span class="material-symbols-outlined text-4xl">event_busy</span>
            </div>
            <h3 class="text-xl font-bold text-gray-500 mb-2">Tidak Ada Jadwal</h3>
            <p class="text-sm text-gray-400 mb-4">Belum ada jadwal ibadah yang tersedia untuk filter yang dipilih.</p>
            <a href="{{ route('jadwal.index') }}" class="text-primary font-semibold text-sm hover:underline">
                Lihat Semua Jadwal
            </a>
        </div>
        @endif
    </div>
</main>
@endsection