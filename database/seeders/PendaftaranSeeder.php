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
            // Budi: baptis disetujui, nikah pending
            ['user_id' => $budi->id,   'jenis' => 'baptis', 'tanggal_daftar' => Carbon::now()->subMonths(3)->format('Y-m-d'), 'status' => 'disetujui'],
            ['user_id' => $budi->id,   'jenis' => 'nikah',  'tanggal_daftar' => Carbon::now()->addMonths(2)->format('Y-m-d'), 'status' => 'pending'],

            // Sari: sidi disetujui, nikah disetujui
            ['user_id' => $sari->id,   'jenis' => 'sidi',   'tanggal_daftar' => Carbon::now()->subMonths(2)->format('Y-m-d'), 'status' => 'disetujui'],
            ['user_id' => $sari->id,   'jenis' => 'nikah',  'tanggal_daftar' => Carbon::now()->addMonth()->format('Y-m-d'),  'status' => 'disetujui'],

            // Hendra: baptis ditolak, ulang pending
            ['user_id' => $hendra->id, 'jenis' => 'baptis', 'tanggal_daftar' => Carbon::now()->subMonths(4)->format('Y-m-d'), 'status' => 'ditolak'],
            ['user_id' => $hendra->id, 'jenis' => 'baptis', 'tanggal_daftar' => Carbon::now()->addMonths(1)->format('Y-m-d'), 'status' => 'pending'],

            // Dewi: sidi pending
            ['user_id' => $dewi->id,   'jenis' => 'sidi',   'tanggal_daftar' => Carbon::now()->addMonths(2)->format('Y-m-d'), 'status' => 'pending'],

            // Agus: baptis disetujui
            ['user_id' => $agus->id,   'jenis' => 'baptis', 'tanggal_daftar' => Carbon::now()->subMonth()->format('Y-m-d'),  'status' => 'disetujui'],
        ];

        foreach ($data as $item) {
            Pendaftaran::create($item);
        }

        $this->command->info('✅ PendaftaranSeeder: 8 pendaftaran selesai.');
    }
}
