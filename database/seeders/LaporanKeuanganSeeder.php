<?php

namespace Database\Seeders;

use App\Models\LaporanKeuangan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Data 6 bulan terakhir agar chart keuangan terlihat berisi
        $bulan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan[] = Carbon::now()->subMonths($i);
        }

        $template = [
            // Pemasukan rutin
            ['jenis' => 'pemasukan',   'jumlah' => 8500000,  'keterangan' => 'Persembahan Minggu I'],
            ['jenis' => 'pemasukan',   'jumlah' => 7200000,  'keterangan' => 'Persembahan Minggu II'],
            ['jenis' => 'pemasukan',   'jumlah' => 9100000,  'keterangan' => 'Persembahan Minggu III'],
            ['jenis' => 'pemasukan',   'jumlah' => 8800000,  'keterangan' => 'Persembahan Minggu IV'],
            ['jenis' => 'pemasukan',   'jumlah' => 3200000,  'keterangan' => 'Persembahan Diakonia'],
            ['jenis' => 'pemasukan',   'jumlah' => 5000000,  'keterangan' => 'Donasi Pembangunan Gedung'],
            // Pengeluaran rutin
            ['jenis' => 'pengeluaran', 'jumlah' => 4500000,  'keterangan' => 'Gaji Staff & Karyawan'],
            ['jenis' => 'pengeluaran', 'jumlah' => 1200000,  'keterangan' => 'Listrik & Air'],
            ['jenis' => 'pengeluaran', 'jumlah' => 800000,   'keterangan' => 'ATK & Kebutuhan Kantor'],
            ['jenis' => 'pengeluaran', 'jumlah' => 2500000,  'keterangan' => 'Pemeliharaan Gedung'],
            ['jenis' => 'pengeluaran', 'jumlah' => 1500000,  'keterangan' => 'Kegiatan Pelayanan & Diakonia'],
            ['jenis' => 'pengeluaran', 'jumlah' => 600000,   'keterangan' => 'Internet & Komunikasi'],
        ];

        foreach ($bulan as $b) {
            foreach ($template as $idx => $item) {
                // Variasi angka sedikit tiap bulan
                $variasi = rand(-500000, 500000);
                $jumlah  = max(100000, $item['jumlah'] + $variasi);

                LaporanKeuangan::create([
                    'tanggal'    => $b->copy()->addDays($idx + 1)->format('Y-m-d'),
                    'jenis'      => $item['jenis'],
                    'jumlah'     => $jumlah,
                    'keterangan' => $item['keterangan'] . ' - ' . $b->format('F Y'),
                    'created_by' => $admin->id,
                    'created_at' => $b->copy()->addDays($idx + 1),
                    'updated_at' => $b->copy()->addDays($idx + 1),
                ]);
            }
        }

        // Tambahan pemasukan & pengeluaran khusus
        $khusus = [
            ['tanggal' => Carbon::now()->subDays(45)->format('Y-m-d'), 'jenis' => 'pemasukan',   'jumlah' => 25000000, 'keterangan' => 'Donasi Anonim untuk Renovasi Kapel'],
            ['tanggal' => Carbon::now()->subDays(40)->format('Y-m-d'), 'jenis' => 'pengeluaran', 'jumlah' => 18000000, 'keterangan' => 'Renovasi Toilet & Ruang Ibadah'],
            ['tanggal' => Carbon::now()->subDays(20)->format('Y-m-d'), 'jenis' => 'pemasukan',   'jumlah' => 12000000, 'keterangan' => 'Dana Natal dari Donatur'],
            ['tanggal' => Carbon::now()->subDays(15)->format('Y-m-d'), 'jenis' => 'pengeluaran', 'jumlah' => 8500000,  'keterangan' => 'Persiapan Perayaan Natal 2025'],
            ['tanggal' => Carbon::now()->subDays(7)->format('Y-m-d'),  'jenis' => 'pemasukan',   'jumlah' => 4500000,  'keterangan' => 'Perpuluhan Jemaat Bulan Ini'],
            ['tanggal' => Carbon::now()->subDays(3)->format('Y-m-d'),  'jenis' => 'pengeluaran', 'jumlah' => 3200000,  'keterangan' => 'Bakti Sosial Panti Asuhan'],
        ];

        foreach ($khusus as $item) {
            LaporanKeuangan::create(array_merge($item, ['created_by' => $admin->id]));
        }

        $this->command->info('✅ LaporanKeuanganSeeder: data 6 bulan + khusus selesai.');
    }
}