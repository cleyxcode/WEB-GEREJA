@extends('frontend.layouts.app')

@section('title', 'Detail Jadwal Ibadah')

@section('content')
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-20 xl:px-40">
    <div class="flex flex-col max-w-[1000px] w-full flex-1 gap-8">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 px-1">
            <a class="text-[#637588] text-sm font-medium leading-normal hover:underline" href="{{ route('home') }}">Beranda</a>
            <span class="text-[#637588] text-sm font-medium leading-normal">/</span>
            <a class="text-[#637588] text-sm font-medium leading-normal hover:underline" href="{{ route('jadwal.index') }}">Jadwal Ibadah</a>
            <span class="text-[#637588] text-sm font-medium leading-normal">/</span>
            <span class="text-[#111418] text-sm font-medium leading-normal">Detail</span>
        </div>

        <!-- Back Button -->
        <div>
            <a href="{{ route('jadwal.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#637588] hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Daftar Jadwal
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg border border-[#e5e7eb] overflow-hidden">
            <!-- Header with gradient -->
            <div class="relative bg-gradient-to-r from-primary to-blue-600 text-white p-8">
                <div class="absolute inset-0 bg-cover bg-center opacity-10" 
                     style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDIn63uoGarzfGaSE9pohLPCKPQEKwNL06ndlZju33aNlCVgeaPBkvIKHEYxqUdse2i6dQqHsxRLG0zAWSCjOLOLJyOWg6-crVSn8mn1VQCa8FmLuttukuIOjQu8of1CnjvU064k5av3DocJXA84iFslq9cDawzRuEz7y0CKmUTRI8rPqA50v7cIAE_6rkhftU0FcPVU8F9fmNZNoNfZS6VxbuLzptNuzPAbolYPyW7UzyxXFsIj3K3baxf9IFSKdxPqbM68pyM5gzQ');">
                </div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-blue-100 text-sm font-semibold uppercase tracking-wider">
                        <span class="material-symbols-outlined">event</span>
                        Jadwal Ibadah
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black">
                        {{ $jadwal->tanggal->isoFormat('dddd, D MMMM YYYY') }}
                    </h1>
                    <div class="flex flex-wrap gap-4 text-blue-50">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined">schedule</span>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined">location_on</span>
                            <span class="font-semibold">{{ $jadwal->tempat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-8">
                <!-- Petugas Pelayanan -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-[#111418] flex items-center gap-2">
                        <span class="w-1 h-6 bg-primary rounded-full"></span>
                        Petugas Pelayanan
                    </h2>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center gap-4">
                            <div class="size-16 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-2xl">
                                {{ strtoupper(substr($jadwal->petugas_ibadah, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm text-[#637588] mb-1">Petugas</p>
                                <p class="text-xl font-bold text-[#111418]">{{ $jadwal->petugas_ibadah }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liturgi Text -->
                @if($jadwal->liturgi_text)
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-[#111418] flex items-center gap-2">
                        <span class="w-1 h-6 bg-primary rounded-full"></span>
                        Tata Ibadah / Liturgi
                    </h2>
                    <div class="bg-white border border-[#e5e7eb] rounded-lg p-6">
                        <div class="prose prose-sm max-w-none text-[#111418]">
                            {!! nl2br(e($jadwal->liturgi_text)) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Download Liturgi File -->
                @if($jadwal->liturgi_file)
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-[#111418] flex items-center gap-2">
                        <span class="w-1 h-6 bg-primary rounded-full"></span>
                        File Liturgi
                    </h2>
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-100 rounded-lg p-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                                    <span class="material-symbols-outlined text-[28px]">description</span>
                                </div>
                                <div>
                                    <p class="font-bold text-[#111418] mb-1">File Liturgi Tersedia</p>
                                    <p class="text-sm text-[#637588]">Download file liturgi lengkap dalam format PDF/DOC</p>
                                    <p class="text-xs text-[#9ca3af] mt-1">{{ basename($jadwal->liturgi_file) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('jadwal.download-liturgi', $jadwal->id) }}" 
                               class="flex-shrink-0 bg-primary hover:bg-primary-dark text-white font-bold text-sm px-6 py-3 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined">download</span>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Info Tambahan -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-6">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-[24px]">info</span>
                        <div class="flex-1">
                            <p class="font-semibold text-[#111418] mb-1">Informasi Penting</p>
                            <p class="text-sm text-[#637588]">
                                Mohon hadir 15 menit sebelum ibadah dimulai. Untuk informasi lebih lanjut, silakan hubungi sekretariat gereja.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Meta Information -->
                <div class="border-t border-[#e5e7eb] pt-6">
                    <div class="flex flex-wrap gap-6 text-sm text-[#637588]">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#9ca3af]">person</span>
                            <span>Dibuat oleh: <strong class="text-[#111418]">{{ $jadwal->creator->name }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#9ca3af]">calendar_today</span>
                            <span>Dibuat: <strong class="text-[#111418]">{{ $jadwal->created_at->isoFormat('D MMM YYYY, HH:mm') }}</strong></span>
                        </div>
                        @if($jadwal->updated_at != $jadwal->created_at)
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#9ca3af]">update</span>
                            <span>Diperbarui: <strong class="text-[#111418]">{{ $jadwal->updated_at->isoFormat('D MMM YYYY, HH:mm') }}</strong></span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Schedules -->
        @php
            $relatedJadwal = \App\Models\JadwalIbadah::where('id', '!=', $jadwal->id)
                ->where('tanggal', '>=', now())
                ->orderBy('tanggal', 'asc')
                ->take(3)
                ->get();
        @endphp

        @if($relatedJadwal->count() > 0)
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-[#111418] flex items-center gap-2">
                <span class="w-1.5 h-8 bg-primary rounded-full"></span>
                Jadwal Ibadah Lainnya
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedJadwal as $related)
                <a href="{{ route('jadwal.show', $related->id) }}" class="block bg-white rounded-xl shadow border border-[#f0f2f5] hover:shadow-lg transition-all overflow-hidden group">
                    <div class="h-2 bg-primary"></div>
                    <div class="p-5 space-y-3">
                        <h3 class="text-lg font-bold text-[#111418] group-hover:text-primary transition-colors">
                            {{ $related->tanggal->format('d M Y') }}
                        </h3>
                        <div class="space-y-2 text-sm text-[#637588]">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">schedule</span>
                                {{ \Carbon\Carbon::parse($related->waktu)->format('H:i') }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">location_on</span>
                                {{ $related->tempat }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
// Show toast if download success/error
@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showToast('{{ session('error') }}', 'error');
@endif
</script>
@endpush