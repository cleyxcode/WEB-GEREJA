@extends('frontend.layouts.app')

@section('title', $berita->judul)

@section('content')
<main class="flex-grow w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Article -->
        <article class="lg:col-span-8 flex flex-col gap-8">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-[#60708a]">
                <a class="hover:text-primary" href="{{ route('home') }}">Beranda</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <a class="hover:text-primary" href="{{ route('berita.index') }}">Berita</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-[#111418] truncate max-w-[200px]">{{ $berita->judul }}</span>
            </div>

            <!-- Back Button -->
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#60708a] hover:text-primary transition-colors w-fit">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Daftar Berita
            </a>

            <!-- Article Card -->
            <div class="bg-white rounded-2xl overflow-hidden border border-[#f0f2f5] shadow-sm">
                <!-- Hero Image -->
                @if($berita->gambar)
                <div class="relative h-72 md:h-96 overflow-hidden">
                    <img 
                        alt="{{ $berita->judul }}" 
                        class="w-full h-full object-cover"
                        src="{{ asset('storage/' . $berita->gambar) }}"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <div class="absolute top-6 left-6">
                        <span class="bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-primary shadow-sm">
                            Berita
                        </span>
                    </div>
                </div>
                @else
                <div class="relative h-48 bg-gradient-to-br from-primary/20 to-blue-200 flex items-center justify-center">
                    <span class="material-symbols-outlined text-8xl text-primary/20">article</span>
                    <div class="absolute top-6 left-6">
                        <span class="bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-primary shadow-sm">
                            Berita
                        </span>
                    </div>
                </div>
                @endif

                <!-- Content -->
                <div class="p-6 md:p-10 space-y-6">
                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-[#60708a]">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            <span>{{ $berita->created_at->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">person</span>
                            <span>{{ $berita->creator->name }}</span>
                        </div>
                        @if($berita->updated_at != $berita->created_at)
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">update</span>
                            <span>Diperbarui: {{ $berita->updated_at->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-black text-[#111418] leading-tight tracking-tight">
                        {{ $berita->judul }}
                    </h1>

                    <hr class="border-[#f0f2f5]">

                    <!-- Article Body -->
                    <div class="prose prose-lg max-w-none text-[#374151] leading-relaxed">
                        {!! $berita->isi !!}
                    </div>

                    <!-- Share Section -->
                    <div class="pt-6 border-t border-[#f0f2f5]">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <p class="text-sm font-semibold text-[#111418]">Bagikan artikel ini:</p>
                            <div class="flex gap-3">
                                <button onclick="copyLink()" class="flex items-center gap-2 px-4 py-2 bg-[#f0f2f5] hover:bg-gray-200 text-[#60708a] rounded-lg text-sm font-medium transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">link</span>
                                    Salin Link
                                </button>
                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-sm font-medium transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">share</span>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 flex flex-col gap-6">
            <!-- Berita Lainnya -->
            @if($beritaLainnya->count() > 0)
            <div class="bg-white rounded-2xl border border-[#f0f2f5] shadow-sm overflow-hidden sticky top-24">
                <div class="px-6 py-4 border-b border-[#f0f2f5]">
                    <h3 class="text-lg font-bold text-[#111418] flex items-center gap-2">
                        <span class="w-1 h-5 bg-primary rounded-full"></span>
                        Berita Lainnya
                    </h3>
                </div>
                <div class="divide-y divide-[#f0f2f5]">
                    @foreach($beritaLainnya as $other)
                    <a href="{{ route('berita.show', $other->id) }}" class="flex gap-4 p-4 hover:bg-[#f5f7f8] transition-colors group">
                        <!-- Thumbnail -->
                        <div class="w-20 h-16 rounded-lg overflow-hidden flex-shrink-0">
                            @if($other->gambar)
                                <img 
                                    alt="{{ $other->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                    src="{{ asset('storage/' . $other->gambar) }}"
                                />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-blue-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-2xl text-primary/40">article</span>
                                </div>
                            @endif
                        </div>
                        <!-- Info -->
                        <div class="flex flex-col justify-center gap-1 flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-[#111418] leading-tight group-hover:text-primary transition-colors line-clamp-2">
                                {{ $other->judul }}
                            </h4>
                            <p class="text-xs text-[#60708a] flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                {{ $other->created_at->isoFormat('D MMM YYYY') }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="p-4 border-t border-[#f0f2f5]">
                    <a href="{{ route('berita.index') }}" class="flex items-center justify-center gap-2 w-full py-2.5 bg-primary/5 hover:bg-primary/10 text-primary rounded-lg text-sm font-semibold transition-colors">
                        Lihat Semua Berita
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined">church</span>
                    </div>
                    <h4 class="font-bold text-[#111418]">Gereja Bethesda</h4>
                </div>
                <p class="text-sm text-[#60708a] leading-relaxed">
                    Menjadi gereja yang memuliakan Tuhan, membangun jemaat, dan menjadi berkat bagi sesama.
                </p>
                <a href="{{ route('jadwal.index') }}" class="flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                    <span class="material-symbols-outlined text-[18px]">event</span>
                    Lihat Jadwal Ibadah
                </a>
            </div>
        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        showToast('Link berhasil disalin!', 'success');
    }).catch(function() {
        showToast('Gagal menyalin link', 'error');
    });
}
</script>
@endpush