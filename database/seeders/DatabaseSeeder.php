<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Memulai proses seeding...');
        $this->command->newLine();

        $this->call([
            UserSeeder::class,
            JadwalIbadahSeeder::class,
            BeritaSeeder::class,
            PendaftaranSeeder::class,
            LaporanKeuanganSeeder::class,
            SaranSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('🎉 ============================================');
        $this->command->info('🎉  SEMUA DATA BERHASIL DI-SEED!');
        $this->command->info('🎉 ============================================');
        $this->command->newLine();
        $this->command->info('📋 AKUN YANG TERSEDIA:');
        $this->command->newLine();
        $this->command->table(
            ['Role', 'Nama', 'Email', 'Password'],
            [
                ['👑 Admin',  'Administrator',      'admin@gerejabethesda.com', 'Admin@1234'],
                ['👤 Jemaat', 'Budi Santoso',        'budi@email.com',           'password123'],
                ['👤 Jemaat', 'Sari Widya Ningrum',  'sari@email.com',           'password123'],
                ['👤 Jemaat', 'Hendra Kusuma',        'hendra@email.com',         'password123'],
                ['👤 Jemaat', 'Dewi Lestari',         'dewi@email.com',           'password123'],
                ['👤 Jemaat', 'Agus Prasetyo',        'agus@email.com',           'password123'],
            ]
        );
        $this->command->newLine();
        $this->command->info('📊 DATA YANG DI-SEED:');
        $this->command->table(
            ['Tabel', 'Jumlah Data'],
            [
                ['users',             '6 akun (1 admin + 5 jemaat)'],
                ['jadwal_ibadah',     '8 jadwal (4 lampau + 4 mendatang)'],
                ['berita',            '8 berita'],
                ['pendaftaran',       '8 pendaftaran (berbagai status)'],
                ['laporan_keuangan',  '78 transaksi (6 bulan + khusus)'],
                ['saran',             '10 saran (2 per jemaat)'],
            ]
        );
    }
}