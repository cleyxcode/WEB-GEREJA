@extends('frontend.layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<main class="flex-1 px-4 md:px-10 py-8 max-w-[1440px] mx-auto w-full">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Laporan Keuangan</h1>
            <p class="text-slate-500 mt-1">Ringkasan arus kas, pemasukan, dan pengeluaran gereja.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm text-slate-700">
                <span class="material-symbols-outlined text-[20px]">print</span>
                <span>Cetak</span>
            </button>
            <a href="{{ route('keuangan.export', request()->query()) }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-blue-200">
                <span class="material-symbols-outlined text-[20px]">download</span>
                <span>Export Excel</span>
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pemasukan Card -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-9xl text-green-600">trending_up</span>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-green-50 rounded-lg text-green-600">
                        <span class="material-symbols-outlined text-2xl">arrow_upward</span>
                    </div>
                    <span class="text-sm font-medium text-slate-500">Total Pemasukan</span>
                </div>
                <div class="flex items-end gap-3">
                    <h3 class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                    @if($pemasukanPercentage != 0)
                    <span class="text-xs font-medium {{ $pemasukanPercentage > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full mb-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">{{ $pemasukanPercentage > 0 ? 'trending_up' : 'trending_down' }}</span> 
                        {{ $pemasukanPercentage > 0 ? '+' : '' }}{{ number_format($pemasukanPercentage, 1) }}%
                    </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mt-2">Update terakhir: {{ now()->isoFormat('D MMMM YYYY') }}</p>
            </div>
        </div>

        <!-- Pengeluaran Card -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-9xl text-red-600">trending_down</span>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-red-50 rounded-lg text-red-600">
                        <span class="material-symbols-outlined text-2xl">arrow_downward</span>
                    </div>
                    <span class="text-sm font-medium text-slate-500">Total Pengeluaran</span>
                </div>
                <div class="flex items-end gap-3">
                    <h3 class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                    @if($pengeluaranPercentage != 0)
                    <span class="text-xs font-medium {{ $pengeluaranPercentage < 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full mb-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">{{ $pengeluaranPercentage < 0 ? 'arrow_downward' : 'arrow_upward' }}</span> 
                        {{ number_format(abs($pengeluaranPercentage), 1) }}%
                    </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mt-2">{{ $pengeluaranPercentage < 0 ? 'Lebih hemat dari bulan lalu' : 'Dari bulan lalu' }}</p>
            </div>
        </div>

        <!-- Saldo Card -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group ring-1 ring-primary/10">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-9xl text-primary">account_balance_wallet</span>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined text-2xl">account_balance</span>
                    </div>
                    <span class="text-sm font-medium text-slate-500">Saldo Akhir</span>
                </div>
                <div class="flex items-end gap-3">
                    <h3 class="text-3xl font-bold text-slate-900 tracking-tight">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                </div>
                @php
                    $targetBulanan = 150000000; // Target 150 juta
                    $percentage = $targetBulanan > 0 ? ($saldo / $targetBulanan) * 100 : 0;
                    $percentage = min($percentage, 100); // Max 100%
                @endphp
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4 overflow-hidden">
                    <div class="bg-primary h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
                <p class="text-xs text-slate-400 mt-2 flex justify-between">
                    <span>Target Bulanan</span>
                    <span>{{ number_format($percentage, 0) }}% Terpenuhi</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Filters & Table Section -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        <form method="GET" action="{{ route('keuangan.index') }}" class="p-5 border-b border-slate-200 flex flex-col sm:flex-row gap-4 justify-between items-center bg-white">
            <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                <!-- Date Filter -->
                <div class="relative group">
                    <select name="bulan" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-3 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 cursor-pointer hover:bg-slate-100 transition-colors">
                        <option value="">Semua Bulan</option>
                        @foreach($months as $month)
                            <option value="{{ $month['value'] }}" {{ request('bulan') == $month['value'] ? 'selected' : '' }}>
                                {{ $month['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                    </div>
                </div>

                <!-- Type Filter -->
                <div class="relative group">
                    <select name="jenis" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-3 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 cursor-pointer hover:bg-slate-100 transition-colors">
                        <option value="">Semua Jenis</option>
                        <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    </div>
                </div>

                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                    Terapkan
                </button>

                @if(request()->hasAny(['bulan', 'jenis', 'search']))
                <a href="{{ route('keuangan.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                    Reset
                </a>
                @endif
            </div>

            <!-- Search -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input name="search" value="{{ request('search') }}" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2 placeholder-slate-400" placeholder="Cari keterangan..." type="text"/>
            </div>
        </form>

        <!-- Table -->
        @if($transaksiList->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-40">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-40">Jenis</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right w-48">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach($transaksiList as $transaksi)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $transaksi->tanggal->isoFormat('DD MMM YYYY') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaksi->jenis == 'pemasukan')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                Pemasukan
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                Pengeluaran
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-900 font-medium">
                            {{ $transaksi->keterangan ?? 'Transaksi' }}
                            <p class="text-xs text-slate-500 font-normal mt-0.5">Oleh: {{ $transaksi->creator->name }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900 text-right">
                            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between bg-white">
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-medium">{{ $transaksiList->firstItem() ?? 0 }}</span> 
                sampai <span class="font-medium">{{ $transaksiList->lastItem() ?? 0 }}</span> 
                dari <span class="font-medium">{{ $transaksiList->total() }}</span> transaksi
            </p>
            <div class="flex gap-2">
                {{ $transaksiList->links('pagination::tailwind') }}
            </div>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                <span class="material-symbols-outlined text-4xl text-slate-400">receipt_long</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Tidak Ada Transaksi</h3>
            <p class="text-sm text-slate-500">Belum ada transaksi keuangan untuk filter yang dipilih.</p>
        </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
@if(session('info'))
    showToast('{{ session('info') }}', 'success');
@endif
</script>
@endpush