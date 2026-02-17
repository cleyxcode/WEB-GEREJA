@extends('frontend.layouts.app')

@section('title', 'Pendaftaran Layanan')

@section('content')
<main class="flex-grow w-full max-w-[1440px] mx-auto px-6 md:px-10 lg:px-40 py-10">
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-neutral-900 mb-2">Pendaftaran Layanan Gereja</h1>
        <p class="text-neutral-500 text-lg">Kelola pendaftaran sakramen dan layanan gerejawi Anda dalam satu tempat.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Left Column: Registration Form -->
        <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">
            <div class="bg-white rounded-xl border border-neutral-200 shadow-sm overflow-hidden">
                <div class="bg-primary/5 border-b border-neutral-200 px-6 py-4">
                    <h2 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">edit_document</span>
                        Formulir Pendaftaran
                    </h2>
                </div>
                
                <form id="pendaftaranForm" class="p-6 flex flex-col gap-5">
                    @csrf
                    
                    <!-- Jenis Layanan -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700" for="jenis">Jenis Layanan</label>
                        <div class="relative">
                            <select name="jenis" id="jenis" class="w-full appearance-none rounded-lg border border-neutral-300 bg-white px-4 py-3 pr-10 text-neutral-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all" required>
                                <option value="" disabled selected>Pilih jenis layanan...</option>
                                <option value="baptis">Baptis Kudus</option>
                                <option value="sidi">Sidi (Peneguhan)</option>
                                <option value="nikah">Pemberkatan Nikah</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-neutral-500">keyboard_arrow_down</span>
                        </div>
                        <span class="text-xs text-red-500 hidden" id="jenis-error"></span>
                    </div>

                    <!-- Tanggal Pelaksanaan -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700" for="tanggal_daftar">Tanggal Pelaksanaan</label>
                        <div class="relative">
                            <input 
                                type="date" 
                                name="tanggal_daftar" 
                                id="tanggal_daftar"
                                min="{{ now()->addDays(14)->format('Y-m-d') }}"
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-neutral-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all" 
                                required
                            />
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-neutral-500 bg-white pl-2">calendar_month</span>
                        </div>
                        <p class="text-xs text-neutral-500 mt-1">Mohon pilih tanggal minimal 2 minggu dari hari ini.</p>
                        <span class="text-xs text-red-500 hidden" id="tanggal_daftar-error"></span>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700" for="catatan">
                            Catatan Tambahan <span class="font-normal text-neutral-400">(Opsional)</span>
                        </label>
                        <textarea 
                            name="catatan" 
                            id="catatan"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-neutral-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-neutral-400" 
                            placeholder="Informasi tambahan untuk majelis..." 
                            rows="3"
                        ></textarea>
                    </div>

                    <!-- Action Button -->
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="mt-2 w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3.5 px-6 rounded-lg shadow-lg shadow-primary/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2 group"
                    >
                        <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform">send</span>
                        Ajukan Pendaftaran
                    </button>
                </form>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 flex gap-4">
                <span class="material-symbols-outlined text-primary shrink-0">info</span>
                <div>
                    <h4 class="font-semibold text-neutral-900 text-sm mb-1">Informasi Penting</h4>
                    <p class="text-sm text-neutral-600 leading-relaxed">
                        Pastikan data diri di menu <a class="text-primary font-medium hover:underline" href="{{ route('profile') }}">Profil</a> sudah lengkap sebelum mengajukan layanan. Hubungi sekretariat jika ada kendala.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column: Registration History -->
        <div class="lg:col-span-7 xl:col-span-8">
            <div class="bg-white rounded-xl border border-neutral-200 shadow-sm flex flex-col h-full min-h-[500px]">
                <div class="px-6 py-5 border-b border-neutral-200 flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-neutral-500">history</span>
                        Riwayat Pendaftaran
                    </h2>
                    
                    <!-- Search -->
                    <form method="GET" action="{{ route('pendaftaran.index') }}" class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-neutral-400 text-[20px]">search</span>
                        <input 
                            name="search" 
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-200 bg-neutral-50 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" 
                            placeholder="Cari riwayat..." 
                            type="text"
                        />
                    </form>
                </div>

                @if($pendaftaranList->count() > 0)
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 border-b border-neutral-200">
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Jenis Layanan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Rencana Pelaksanaan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider text-right">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach($pendaftaranList as $pendaftaran)
                            <tr class="group hover:bg-neutral-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded-full {{ $pendaftaran->jenis == 'baptis' ? 'bg-yellow-100 text-yellow-600' : ($pendaftaran->jenis == 'sidi' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600') }} flex items-center justify-center">
                                            <span class="material-symbols-outlined text-lg">
                                                {{ $pendaftaran->jenis == 'baptis' ? 'child_care' : ($pendaftaran->jenis == 'sidi' ? 'diversity_3' : 'volunteer_activism') }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-neutral-900">
                                                {{ ucfirst($pendaftaran->jenis) }}
                                                @if($pendaftaran->jenis == 'sidi')
                                                    (Peneguhan)
                                                @elseif($pendaftaran->jenis == 'nikah')
                                                    Nikah
                                                @else
                                                    Kudus
                                                @endif
                                            </p>
                                            <p class="text-xs text-neutral-500">{{ $pendaftaran->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                    {{ $pendaftaran->created_at->isoFormat('DD MMM YYYY') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->isoFormat('DD MMM YYYY') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($pendaftaran->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <span class="size-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                    @elseif($pendaftaran->status == 'disetujui')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="material-symbols-outlined text-[14px]">check</span>
                                        Disetujui
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <span class="material-symbols-outlined text-[14px]">close</span>
                                        Ditolak
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($pendaftaran->status == 'pending')
                                    <button onclick="batalkanPendaftaran({{ $pendaftaran->id }})" class="text-red-400 hover:text-red-600 transition-colors" title="Batalkan Pendaftaran">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                    @else
                                    <span class="text-neutral-300">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-neutral-200 flex items-center justify-between">
                    <p class="text-sm text-neutral-500">
                        Menampilkan <span class="font-medium text-neutral-900">{{ $pendaftaranList->firstItem() ?? 0 }}</span> 
                        sampai <span class="font-medium text-neutral-900">{{ $pendaftaranList->lastItem() ?? 0 }}</span> 
                        dari <span class="font-medium text-neutral-900">{{ $pendaftaranList->total() }}</span> data
                    </p>
                    <div class="flex gap-2">
                        {{ $pendaftaranList->links('pagination::tailwind') }}
                    </div>
                </div>
                @else
                <div class="flex-grow flex items-center justify-center p-12">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 mb-4">
                            <span class="material-symbols-outlined text-4xl text-neutral-400">event_busy</span>
                        </div>
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Belum Ada Pendaftaran</h3>
                        <p class="text-sm text-neutral-500">Anda belum mengajukan pendaftaran layanan apapun.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Submit Form
document.getElementById('pendaftaranForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Clear previous errors
    document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));
    
    // Set loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <div class="spinner"></div>
        <span>Memproses...</span>
    `;
    
    try {
        const response = await fetch('{{ route("pendaftaran.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast(result.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
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
            showToast(result.message || 'Terjadi kesalahan', 'error');
            
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform">send</span>
                Ajukan Pendaftaran
            `;
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform">send</span>
            Ajukan Pendaftaran
        `;
    }
});

// Batalkan Pendaftaran
async function batalkanPendaftaran(id) {
    if (!confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?')) {
        return;
    }
    
    try {
        const response = await fetch(`/pendaftaran/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast(result.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(result.message || 'Gagal membatalkan pendaftaran', 'error');
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
    }
}
</script>
@endpush