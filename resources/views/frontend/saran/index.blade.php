@extends('frontend.layouts.app')

@section('title', 'Kotak Saran')

@section('content')
<main class="flex-1 flex justify-center py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-[960px] w-full flex flex-col gap-8">
        <!-- Hero / Header Section -->
        <section class="flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined text-2xl">mail</span>
                </div>
                <h1 class="text-[#111418] text-3xl font-black leading-tight tracking-[-0.033em]">Kotak Saran Jemaat</h1>
            </div>
            <p class="text-[#60708a] text-base font-normal leading-normal max-w-2xl">
                Suara Anda sangat berarti bagi kemajuan pelayanan Gereja Bethesda. Sampaikan aspirasi, kritik yang membangun, atau ide-ide kreatif Anda di sini.
            </p>
        </section>

        <!-- Form Section -->
        <section class="bg-white rounded-xl border border-[#dbdfe6] p-6 shadow-sm">
            <form id="saranForm" class="flex flex-col gap-6">
                @csrf
                
                <div class="flex flex-col gap-2">
                    <label class="text-[#111418] text-base font-medium leading-normal" for="isi_saran">Isi Saran / Aspirasi</label>
                    <textarea 
                        name="isi_saran" 
                        id="isi_saran"
                        class="w-full resize-y overflow-hidden rounded-lg text-[#111418] placeholder:text-[#60708a] border border-[#dbdfe6] bg-white p-4 text-base font-normal leading-normal focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow" 
                        placeholder="Tuliskan detail saran Anda di sini. Semakin spesifik, semakin baik kami dapat menindaklanjutinya..." 
                        rows="6"
                        required
                    ></textarea>
                    <p class="text-xs text-[#60708a]">Saran Anda akan dikirimkan langsung ke majelis gereja.</p>
                    <span class="text-xs text-red-500 hidden" id="isi_saran-error"></span>
                </div>

                <div class="flex justify-end pt-2">
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="flex min-w-[140px] cursor-pointer items-center justify-center gap-2 rounded-lg h-12 px-6 bg-primary hover:bg-primary/90 text-white text-base font-bold leading-normal tracking-[0.015em] transition-colors shadow-md shadow-primary/20"
                    >
                        <span class="material-symbols-outlined text-[20px]">send</span>
                        <span>Kirim Saran</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- History Section -->
        <section class="flex flex-col gap-5">
            <div class="flex items-center justify-between">
                <h2 class="text-[#111418] text-xl font-bold leading-tight">Riwayat Saran Saya</h2>
                <div class="hidden sm:flex items-center gap-2 text-sm text-[#60708a]">
                    <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-primary"></span> Baru</span>
                    <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-amber-500"></span> Dibaca</span>
                    <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-emerald-500"></span> Ditindaklanjuti</span>
                </div>
            </div>

            <!-- History List -->
            @if($saranList->count() > 0)
            <div class="grid gap-4">
                @foreach($saranList as $saran)
                <div class="group bg-white rounded-xl p-5 border border-[#dbdfe6] shadow-sm hover:shadow-md transition-all {{ $saran->status == 'baru' ? 'hover:border-primary/30' : '' }}">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            @if($saran->status == 'baru')
                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold border border-primary/20">Baru</span>
                            @elseif($saran->status == 'dibaca')
                            <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 text-xs font-bold border border-amber-500/20">Dibaca</span>
                            @else
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 text-xs font-bold border border-emerald-500/20">Ditindaklanjuti</span>
                            @endif
                            <span class="text-xs text-[#60708a]">{{ $saran->created_at->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[#60708a]">
                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            <span class="text-xs font-medium">Dikirim: {{ $saran->created_at->isoFormat('D MMM YYYY') }}</span>
                        </div>
                    </div>
                    
                    <p class="text-[#60708a] text-sm leading-relaxed mb-4">
                        {{ $saran->isi_saran }}
                    </p>

                    @if($saran->status == 'dibaca')
                    <div class="bg-background-light rounded-lg p-3 text-xs text-[#60708a] flex gap-2 items-start">
                        <span class="material-symbols-outlined text-[16px] text-amber-500 mt-0.5">info</span>
                        <p>Admin: "Terima kasih atas masukannya, akan kami tindaklanjuti."</p>
                    </div>
                    @elseif($saran->status == 'ditindaklanjuti')
                    <div class="bg-emerald-50 rounded-lg p-3 text-xs text-emerald-800 flex gap-2 items-start border border-emerald-100">
                        <span class="material-symbols-outlined text-[16px] text-emerald-600 mt-0.5">check_circle</span>
                        <p>Admin: "Saran Anda telah kami tindaklanjuti. Terima kasih atas partisipasinya."</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-12 text-center bg-white rounded-xl border border-dashed border-[#dbdfe6]">
                <div class="size-16 bg-background-light rounded-full flex items-center justify-center mb-4 text-[#60708a]">
                    <span class="material-symbols-outlined text-3xl">inbox</span>
                </div>
                <h3 class="text-[#111418] font-semibold text-lg">Belum ada saran</h3>
                <p class="text-[#60708a] text-sm mt-1">Saran yang Anda kirimkan akan muncul di sini.</p>
            </div>
            @endif
        </section>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Submit Form
document.getElementById('saranForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const textarea = document.getElementById('isi_saran');
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Clear previous errors
    document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));
    
    // Validation
    if (!data.isi_saran || data.isi_saran.trim().length < 10) {
        document.getElementById('isi_saran-error').textContent = 'Saran minimal 10 karakter';
        document.getElementById('isi_saran-error').classList.remove('hidden');
        return;
    }
    
    // Set loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <div class="spinner"></div>
        <span>Mengirim...</span>
    `;
    
    try {
        const response = await fetch('{{ route("saran.store") }}', {
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
            textarea.value = ''; // Clear textarea
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
                <span class="material-symbols-outlined text-[20px]">send</span>
                <span>Kirim Saran</span>
            `;
        }
    } catch (error) {
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <span class="material-symbols-outlined text-[20px]">send</span>
            <span>Kirim Saran</span>
        `;
    }
});

// Character counter (optional enhancement)
document.getElementById('isi_saran').addEventListener('input', function() {
    const length = this.value.length;
    const max = 1000;
    
    // You can add a character counter UI here if needed
    if (length > max) {
        this.value = this.value.substring(0, max);
    }
});
</script>
@endpush