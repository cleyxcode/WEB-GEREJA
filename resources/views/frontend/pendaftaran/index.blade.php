@extends('frontend.layouts.app')

@section('title', 'Pendaftaran Layanan')

@section('content')
<main class="flex-grow w-full max-w-[1440px] mx-auto px-6 md:px-10 lg:px-40 py-10">
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-neutral-900 mb-2">Pendaftaran Layanan Gereja</h1>
        <p class="text-neutral-500 text-lg">Kelola pendaftaran sakramen dan layanan gerejawi Anda dalam satu tempat.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- ===== FORM KIRI ===== --}}
        <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">
            <div class="bg-white rounded-xl border border-neutral-200 shadow-sm overflow-hidden">
                <div class="bg-primary/5 border-b border-neutral-200 px-6 py-4">
                    <h2 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">edit_document</span>
                        Formulir Pendaftaran
                    </h2>
                </div>

                <form id="pendaftaranForm" class="p-6 flex flex-col gap-5" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700" for="nama">Nama Lengkap</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-3 text-neutral-400 text-[20px]">person</span>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                placeholder="Masukkan nama lengkap"
                                class="w-full rounded-lg border border-neutral-300 bg-white pl-10 pr-4 py-3 text-neutral-900 placeholder:text-neutral-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                required
                            />
                        </div>
                        <span class="text-xs text-red-500 hidden" id="nama-error"></span>
                    </div>

                    {{-- Jenis Layanan --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700" for="jenis">Jenis Layanan</label>
                        <div class="relative">
                            <select name="jenis" id="jenis"
                                class="w-full appearance-none rounded-lg border border-neutral-300 bg-white px-4 py-3 pr-10 text-neutral-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                required>
                                <option value="" disabled selected>Pilih jenis layanan...</option>
                                <option value="baptis">Baptis Kudus</option>
                                <option value="sidi">Sidi (Peneguhan)</option>
                                <option value="nikah">Pemberkatan Nikah</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-neutral-500">keyboard_arrow_down</span>
                        </div>
                        <span class="text-xs text-red-500 hidden" id="jenis-error"></span>
                    </div>

                    {{-- Tanggal Pelaksanaan --}}
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
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-neutral-500">calendar_month</span>
                        </div>
                        <p class="text-xs text-neutral-400">Minimal 2 minggu dari hari ini.</p>
                        <span class="text-xs text-red-500 hidden" id="tanggal_daftar-error"></span>
                    </div>

                    {{-- Upload Foto --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700">
                            Foto Dokumen <span class="font-normal text-neutral-400">(Opsional)</span>
                        </label>

                        {{-- Dropzone --}}
                        <div id="dropzone"
                             onclick="document.getElementById('foto').click()"
                             class="border-2 border-dashed border-neutral-300 rounded-lg p-6 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-primary hover:bg-primary/5 transition-all group">
                            <span class="material-symbols-outlined text-4xl text-neutral-400 group-hover:text-primary transition-colors">upload_file</span>
                            <p class="text-sm font-medium text-neutral-600 group-hover:text-primary transition-colors">Klik untuk upload foto</p>
                            <p class="text-xs text-neutral-400">JPG, PNG, WEBP • Maks. 2MB</p>
                            <input type="file" name="foto" id="foto" accept="image/*" class="hidden" onchange="previewFoto(this)" />
                        </div>

                        {{-- Preview --}}
                        <div id="foto-preview" class="hidden relative">
                            <img id="foto-preview-img" src="" alt="Preview" class="w-full rounded-lg object-cover max-h-48 border border-neutral-200">
                            <button type="button" onclick="hapusFoto()"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center shadow transition-colors">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                            <p id="foto-preview-name" class="text-xs text-neutral-400 mt-1 truncate"></p>
                        </div>
                        <span class="text-xs text-red-500 hidden" id="foto-error"></span>
                    </div>

                    {{-- Catatan --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-neutral-700" for="catatan">
                            Catatan <span class="font-normal text-neutral-400">(Opsional)</span>
                        </label>
                        <textarea
                            name="catatan"
                            id="catatan"
                            rows="3"
                            placeholder="Informasi tambahan untuk majelis..."
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-neutral-900 placeholder:text-neutral-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                        ></textarea>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="submitBtn"
                        class="mt-2 w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3.5 px-6 rounded-lg shadow-lg shadow-primary/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
                        <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform">send</span>
                        Ajukan Pendaftaran
                    </button>
                </form>
            </div>

            {{-- Info --}}
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 flex gap-4">
                <span class="material-symbols-outlined text-primary shrink-0">info</span>
                <div>
                    <h4 class="font-semibold text-neutral-900 text-sm mb-1">Informasi Penting</h4>
                    <p class="text-sm text-neutral-600 leading-relaxed">
                        Pastikan data diri di menu <a class="text-primary font-medium hover:underline" href="{{ route('profile') }}">Profil</a> sudah lengkap. Hubungi sekretariat jika ada kendala.
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== TABEL RIWAYAT KANAN ===== --}}
        <div class="lg:col-span-7 xl:col-span-8">
            <div class="bg-white rounded-xl border border-neutral-200 shadow-sm flex flex-col h-full min-h-[500px]">
                <div class="px-6 py-5 border-b border-neutral-200 flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-neutral-500">history</span>
                        Riwayat Pendaftaran
                    </h2>
                    <form method="GET" action="{{ route('pendaftaran.index') }}" class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-neutral-400 text-[20px]">search</span>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-200 bg-neutral-50 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
                            placeholder="Cari nama / jenis..."
                            type="text"
                        />
                    </form>
                </div>

                @if($pendaftaranList->count() > 0)
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 border-b border-neutral-200">
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Nama & Layanan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Tgl Daftar</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Tgl Pelaksanaan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider text-center">Foto</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider text-right">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-neutral-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach($pendaftaranList as $item)
                            <tr class="group hover:bg-neutral-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="size-9 rounded-full flex items-center justify-center shrink-0
                                            {{ $item->jenis == 'baptis' ? 'bg-yellow-100 text-yellow-600' : ($item->jenis == 'sidi' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600') }}">
                                            <span class="material-symbols-outlined text-lg">
                                                {{ $item->jenis == 'baptis' ? 'child_care' : ($item->jenis == 'sidi' ? 'diversity_3' : 'volunteer_activism') }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-neutral-900">{{ $item->nama }}</p>
                                            <p class="text-xs text-neutral-500">
                                                {{ $item->jenis == 'baptis' ? 'Baptis Kudus' : ($item->jenis == 'sidi' ? 'Sidi (Peneguhan)' : 'Pemberkatan Nikah') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                    {{ $item->created_at->isoFormat('DD MMM YYYY') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                    {{ $item->tanggal_daftar->isoFormat('DD MMM YYYY') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item->foto)
                                        <button onclick="lihatFoto('{{ Storage::url($item->foto) }}')"
                                            class="inline-flex items-center gap-1 text-xs text-primary hover:underline font-medium">
                                            <span class="material-symbols-outlined text-[16px]">image</span>
                                            Lihat
                                        </button>
                                    @else
                                        <span class="text-neutral-300 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($item->status == 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <span class="size-1.5 rounded-full bg-yellow-500 animate-pulse"></span>Pending
                                        </span>
                                    @elseif($item->status == 'disetujui')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <span class="material-symbols-outlined text-[14px]">check</span>Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            <span class="material-symbols-outlined text-[14px]">close</span>Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($item->status == 'pending')
                                        <button onclick="batalkanPendaftaran({{ $item->id }})"
                                            class="text-red-400 hover:text-red-600 transition-colors" title="Batalkan">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    @else
                                        <span class="text-neutral-300">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-neutral-200 flex items-center justify-between flex-wrap gap-2">
                    <p class="text-sm text-neutral-500">
                        Menampilkan <span class="font-medium text-neutral-900">{{ $pendaftaranList->firstItem() ?? 0 }}</span>
                        sampai <span class="font-medium text-neutral-900">{{ $pendaftaranList->lastItem() ?? 0 }}</span>
                        dari <span class="font-medium text-neutral-900">{{ $pendaftaranList->total() }}</span> data
                    </p>
                    {{ $pendaftaranList->links('pagination::tailwind') }}
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

{{-- Modal Lihat Foto --}}
<div id="modal-foto" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-200">
            <h3 class="font-semibold text-neutral-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">image</span>
                Foto Dokumen
            </h3>
            <button onclick="tutupModal()" class="text-neutral-400 hover:text-neutral-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-5">
            <img id="modal-foto-img" src="" alt="Foto Dokumen" class="w-full rounded-lg object-contain max-h-[70vh]">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    const file = input.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        document.getElementById('foto-error').textContent = 'Ukuran gambar maksimal 2MB';
        document.getElementById('foto-error').classList.remove('hidden');
        input.value = '';
        return;
    }
    document.getElementById('foto-error').classList.add('hidden');

    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('foto-preview-img').src = e.target.result;
        document.getElementById('foto-preview-name').textContent = file.name;
        document.getElementById('foto-preview').classList.remove('hidden');
        document.getElementById('dropzone').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

function hapusFoto() {
    document.getElementById('foto').value = '';
    document.getElementById('foto-preview').classList.add('hidden');
    document.getElementById('dropzone').classList.remove('hidden');
}

function lihatFoto(url) {
    document.getElementById('modal-foto-img').src = url;
    const modal = document.getElementById('modal-foto');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function tutupModal() {
    const modal = document.getElementById('modal-foto');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Tutup modal klik luar
document.getElementById('modal-foto').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});

document.getElementById('pendaftaranForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));

    submitBtn.disabled = true;
    submitBtn.innerHTML = `<div class="spinner"></div><span>Memproses...</span>`;

    const formData = new FormData(this);

    try {
        const response = await fetch('{{ route("pendaftaran.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const result = await response.json();

        if (response.ok) {
            showToast(result.message, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            if (result.errors) {
                Object.keys(result.errors).forEach(key => {
                    const el = document.getElementById(`${key}-error`);
                    if (el) { el.textContent = result.errors[key][0]; el.classList.remove('hidden'); }
                });
            }
            showToast(result.message || 'Terjadi kesalahan', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<span class="material-symbols-outlined">send</span>Ajukan Pendaftaran`;
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<span class="material-symbols-outlined">send</span>Ajukan Pendaftaran`;
    }
});

async function batalkanPendaftaran(id) {
    if (!confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?')) return;

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
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToast(result.message || 'Gagal membatalkan', 'error');
        }
    } catch {
        showToast('Terjadi kesalahan.', 'error');
    }
}
</script>
@endpush