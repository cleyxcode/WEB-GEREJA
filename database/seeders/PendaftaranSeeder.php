<?php

namespace Database\Seeders;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $budi   = User::where('email', 'budi@email.com')->first();
        $sari   = User::where('email', 'sari@email.com')->first();
        $hendra = User::where('email', 'hendra@email.com')->first();
        $dewi   = User::where('email', 'dewi@email.com')->first();
        $agus   = User::where('email', 'agus@email.com')->first();

        $data = [
            // Budi: baptis disetujui
            [
                'user_id'        => $budi->id,
                'nama'           => 'Budi Santoso',
                'jenis'          => 'baptis',
                'tanggal_daftar' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                'status'         => 'disetujui',
                'foto'           => null,
                'catatan'        => 'Baptis kudus untuk anggota baru jemaat.',
            ],
            // Budi: nikah pending
            [
                'user_id'        => $budi->id,
                'nama'           => 'Budi Santoso',
                'jenis'          => 'nikah',
                'tanggal_daftar' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'status'         => 'pending',
                'foto'           => null,
                'catatan'        => 'Pemberkatan nikah dengan calon istri Maria.',
            ],

            // Sari: sidi disetujui
            [
                'user_id'        => $sari->id,
                'nama'           => 'Sari Dewi',
                'jenis'          => 'sidi',
                'tanggal_daftar' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'status'         => 'disetujui',
                'foto'           => null,
                'catatan'        => 'Peneguhan sidi setelah mengikuti kelas katekisasi.',
            ],
            // Sari: nikah disetujui
            [
                'user_id'        => $sari->id,
                'nama'           => 'Sari Dewi',
                'jenis'          => 'nikah',
                'tanggal_daftar' => Carbon::now()->addMonth()->format('Y-m-d'),
                'status'         => 'disetujui',
                'foto'           => null,
                'catatan'        => 'Pemberkatan nikah di gedung gereja utama.',
            ],

            // Hendra: baptis ditolak
            [
                'user_id'        => $hendra->id,
                'nama'           => 'Hendra Wijaya',
                'jenis'          => 'baptis',
                'tanggal_daftar' => Carbon::now()->subMonths(4)->format('Y-m-d'),
                'status'         => 'ditolak',
                'foto'           => null,
                'catatan'        => 'Dokumen belum lengkap, dimohon melengkapi berkas.',
            ],
            // Hendra: baptis ulang pending
            [
                'user_id'        => $hendra->id,
                'nama'           => 'Hendra Wijaya',
                'jenis'          => 'baptis',
                'tanggal_daftar' => Carbon::now()->addMonths(1)->format('Y-m-d'),
                'status'         => 'pending',
                'foto'           => null,
                'catatan'        => 'Pengajuan ulang setelah melengkapi dokumen.',
            ],

            // Dewi: sidi pending
            [
                'user_id'        => $dewi->id,
                'nama'           => 'Dewi Kusuma',
                'jenis'          => 'sidi',
                'tanggal_daftar' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'status'         => 'pending',
                'foto'           => null,
                'catatan'        => null,
            ],

            // Agus: baptis disetujui
            [
                'user_id'        => $agus->id,
                'nama'           => 'Agus Pratama',
                'jenis'          => 'baptis',
                'tanggal_daftar' => Carbon::now()->subMonth()->format('Y-m-d'),
                'status'         => 'disetujui',
                'foto'           => null,
                'catatan'        => 'Baptis kudus untuk anak pertama.',
            ],
        ];

        foreach ($data as $item) {
            Pendaftaran::create($item);
        }

        $this->command->info('✅ PendaftaranSeeder: 8 pendaftaran selesai.');
    }
}