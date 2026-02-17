<?php

namespace Database\Seeders;

use App\Models\JadwalIbadah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JadwalIbadahSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Buat jadwal: 4 minggu lalu sampai 8 minggu ke depan
        $jadwalData = [
            // === LAMPAU ===
            [
                'tanggal'       => Carbon::now()->startOfWeek()->subWeeks(4)->next(Carbon::SUNDAY)->format('Y-m-d'),
                'waktu'         => '07:30:00',
                'tempat'        => 'Gedung Utama Lantai 1',
                'petugas_ibadah'=> 'Pdt. Yohanes Simatupang',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Kasih yang Memulihkan\nNats: Yohanes 3:16\n\n1. Nyanyian Pembukaan: KJ 1 - Terpujilah Allah\n2. Votum dan Salam\n3. Nyanyian Jemaat: PKJ 7\n4. Pengakuan Dosa\n5. Berita Anugerah\n6. Hukum Tuhan\n7. Nyanyian Jemaat: KJ 230\n8. Doa Syafaat\n9. Pembacaan Alkitab: Yohanes 3:14-21\n10. Khotbah\n11. Nyanyian Respons: PKJ 148\n12. Persembahan\n13. Doa Persembahan\n14. Nyanyian Berkat: KJ 478\n15. Berkat",
            ],
            [
                'tanggal'       => Carbon::now()->startOfWeek()->subWeeks(3)->next(Carbon::SUNDAY)->format('Y-m-d'),
                'waktu'         => '09:00:00',
                'tempat'        => 'Gedung Serbaguna',
                'petugas_ibadah'=> 'Pdt. Maria Claudia Tamaela',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Hidup dalam Terang\nNats: Efesus 5:8-14\n\n1. Nyanyian Pembukaan: KJ 5 - Kami Memuji Keagungan-Mu\n2. Votum dan Salam\n3. Nyanyian Jemaat: PKJ 12\n4. Pengakuan Dosa\n5. Berita Anugerah\n6. Hukum Tuhan\n7. Nyanyian Jemaat: KJ 288\n8. Doa Syafaat\n9. Pembacaan Alkitab: Efesus 5:8-14\n10. Khotbah\n11. Nyanyian Respons: PKJ 200\n12. Persembahan\n13. Doa Penutup\n14. Nyanyian Berkat: KJ 485\n15. Berkat",
            ],
            [
                'tanggal'       => Carbon::now()->startOfWeek()->subWeeks(2)->next(Carbon::SUNDAY)->format('Y-m-d'),
                'waktu'         => '07:30:00',
                'tempat'        => 'Gedung Utama Lantai 1',
                'petugas_ibadah'=> 'Ev. Samuel Putra Wijaya',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Iman yang Teguh\nNats: Ibrani 11:1-6\n\n1. Nyanyian Pembukaan: KJ 432\n2. Votum dan Salam\n3. Pengakuan Iman Rasuli\n4. Nyanyian: PKJ 55\n5. Doa Syafaat\n6. Pembacaan Alkitab: Ibrani 11:1-6\n7. Khotbah\n8. Nyanyian Respons: KJ 337\n9. Persembahan\n10. Pengumuman\n11. Nyanyian Berkat: KJ 478\n12. Berkat",
            ],
            [
                'tanggal'       => Carbon::now()->startOfWeek()->subWeeks(1)->next(Carbon::SUNDAY)->format('Y-m-d'),
                'waktu'         => '09:00:00',
                'tempat'        => 'Gedung Utama Lantai 2',
                'petugas_ibadah'=> 'Pdt. Yohanes Simatupang',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Sukacita dalam Tuhan\nNats: Filipi 4:4-7\n\n1. Nyanyian Pembukaan: PKJ 1 - Bersyukurlah kepada Tuhan\n2. Votum dan Salam\n3. Nyanyian Jemaat: KJ 3\n4. Pengakuan Dosa dan Anugerah\n5. Doa Syafaat\n6. Bacaan Alkitab: Filipi 4:4-7\n7. Khotbah: Damai Sejahtera yang Melampaui Akal\n8. Nyanyian: PKJ 148\n9. Persembahan\n10. Doa Berkat\n11. Nyanyian Penutup: KJ 473\n12. Berkat",
            ],
            // === MENDATANG ===
            [
                'tanggal'       => Carbon::now()->next(Carbon::SUNDAY)->format('Y-m-d'),
                'waktu'         => '07:30:00',
                'tempat'        => 'Gedung Utama Lantai 1',
                'petugas_ibadah'=> 'Pdt. Maria Claudia Tamaela',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Pengharapan yang Hidup\nNats: 1 Petrus 1:3-9\n\n1. Nyanyian Pembukaan: KJ 1\n2. Votum dan Salam\n3. Nyanyian Pujian: PKJ 25\n4. Pengakuan Dosa\n5. Berita Anugerah\n6. Doa Syafaat\n7. Bacaan Alkitab: 1 Petrus 1:3-9\n8. Khotbah\n9. Nyanyian Respons: KJ 355\n10. Persembahan\n11. Pengumuman Jemaat\n12. Nyanyian Berkat: KJ 478\n13. Berkat",
            ],
            [
                'tanggal'       => Carbon::now()->next(Carbon::SUNDAY)->addWeeks(1)->format('Y-m-d'),
                'waktu'         => '09:00:00',
                'tempat'        => 'Gedung Serbaguna',
                'petugas_ibadah'=> 'Ev. Samuel Putra Wijaya',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Melayani dengan Sepenuh Hati\nNats: Markus 10:42-45\n\n1. Nyanyian Pembukaan: PKJ 7\n2. Votum dan Salam\n3. Doa Pembuka\n4. Nyanyian Jemaat: KJ 201\n5. Pengakuan Dosa & Anugerah\n6. Bacaan Firman: Markus 10:42-45\n7. Khotbah: Pemimpin yang Melayani\n8. Nyanyian Respons: PKJ 100\n9. Persembahan & Doa\n10. Pengumuman\n11. Berkat",
            ],
            [
                'tanggal'       => Carbon::now()->next(Carbon::SUNDAY)->addWeeks(2)->format('Y-m-d'),
                'waktu'         => '07:30:00',
                'tempat'        => 'Gedung Utama Lantai 1',
                'petugas_ibadah'=> 'Pdt. Yohanes Simatupang',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Bersatu dalam Kristus\nNats: Efesus 4:1-6\n\n1. Nyanyian Pembukaan: KJ 238\n2. Votum dan Salam\n3. Pengakuan Iman: Aku Percaya\n4. Nyanyian: PKJ 55\n5. Doa Syafaat\n6. Bacaan Alkitab: Efesus 4:1-6\n7. Khotbah\n8. Nyanyian Respons: KJ 460\n9. Persembahan\n10. Doa Berkat\n11. Berkat Harun",
            ],
            [
                'tanggal'       => Carbon::now()->next(Carbon::SUNDAY)->addWeeks(3)->format('Y-m-d'),
                'waktu'         => '09:00:00',
                'tempat'        => 'Gedung Utama Lantai 2',
                'petugas_ibadah'=> 'Pdt. Maria Claudia Tamaela',
                'liturgi_text'  => "TATA IBADAH MINGGU\n\nTema: Firman sebagai Pelita\nNats: Mazmur 119:105-112\n\n1. Nyanyian Pembukaan: KJ 5\n2. Votum dan Salam\n3. Nyanyian: PKJ 8\n4. Pembacaan Alkitab: Mazmur 119:105-112\n5. Khotbah\n6. Nyanyian: KJ 316\n7. Persembahan\n8. Doa Penutup\n9. Berkat",
            ],
        ];

        foreach ($jadwalData as $data) {
            JadwalIbadah::updateOrCreate(
                ['tanggal' => $data['tanggal'], 'waktu' => $data['waktu']],
                array_merge($data, ['created_by' => $admin->id])
            );
        }

        $this->command->info('✅ JadwalIbadahSeeder: 8 jadwal ibadah selesai.');
    }
}