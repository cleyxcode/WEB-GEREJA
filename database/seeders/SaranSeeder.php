<?php

namespace Database\Seeders;

use App\Models\Saran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SaranSeeder extends Seeder
{
    public function run(): void
    {
        $budi   = User::where('email', 'budi@email.com')->first();
        $sari   = User::where('email', 'sari@email.com')->first();
        $hendra = User::where('email', 'hendra@email.com')->first();
        $dewi   = User::where('email', 'dewi@email.com')->first();
        $agus   = User::where('email', 'agus@email.com')->first();

        $saranList = [
            // ===== BUDI (2 saran) =====
            [
                'user_id'  => $budi->id,
                'isi_saran'=> 'Saya mengusulkan agar jadwal ibadah pagi ditambah satu sesi lagi mengingat jemaat yang semakin bertambah. Gedung sering kali penuh sesak terutama pada hari Minggu di ibadah pukul 09.00. Mungkin bisa ditambah sesi pukul 11.00 untuk mengakomodasi jemaat yang belum kebagian tempat duduk.',
                'status'   => 'ditindaklanjuti',
                'created_at'=> Carbon::now()->subDays(60),
            ],
            [
                'user_id'  => $budi->id,
                'isi_saran'=> 'Mohon disediakan fasilitas parkir sepeda yang lebih memadai di area gereja. Saat ini banyak jemaat yang menggunakan sepeda namun tempat parkir sangat terbatas dan tidak aman. Hal ini bisa mendorong jemaat untuk lebih ramah lingkungan dalam berkendara ke gereja.',
                'status'   => 'dibaca',
                'created_at'=> Carbon::now()->subDays(15),
            ],

            // ===== SARI (2 saran) =====
            [
                'user_id'  => $sari->id,
                'isi_saran'=> 'Apakah bisa disediakan ruangan khusus untuk ibu menyusui di area gedung gereja? Saat ini cukup sulit bagi ibu-ibu yang membawa bayi untuk mencari tempat yang nyaman dan privat ketika harus menyusui selama ibadah berlangsung. Ini akan sangat membantu para ibu muda dalam jemaat.',
                'status'   => 'ditindaklanjuti',
                'created_at'=> Carbon::now()->subDays(45),
            ],
            [
                'user_id'  => $sari->id,
                'isi_saran'=> 'Tolong dipertimbangkan untuk menambah program kelompok kecil atau sel group yang lebih terstruktur. Banyak jemaat terutama yang baru bergabung merasa belum terhubung dengan komunitas gereja secara personal. Sel group bisa menjadi wadah yang efektif untuk pertumbuhan iman dan fellowship.',
                'status'   => 'baru',
                'created_at'=> Carbon::now()->subDays(5),
            ],

            // ===== HENDRA (2 saran) =====
            [
                'user_id'  => $hendra->id,
                'isi_saran'=> 'Saya menyarankan agar gereja menyediakan live streaming ibadah yang berkualitas baik. Ketika sakit atau ada halangan, jemaat tetap bisa mengikuti ibadah dari rumah. Kualitas audio dan video yang ada saat ini masih perlu ditingkatkan agar lebih jelas dan tidak lag.',
                'status'   => 'dibaca',
                'created_at'=> Carbon::now()->subDays(30),
            ],
            [
                'user_id'  => $hendra->id,
                'isi_saran'=> 'Program mentoring untuk pemuda perlu ditingkatkan. Banyak pemuda yang baru lulus kuliah dan memasuki dunia kerja merasa butuh bimbingan spiritual dan praktis. Akan sangat baik jika gereja memfasilitasi program mentoring antara jemaat senior yang berpengalaman dengan pemuda-pemudi gereja.',
                'status'   => 'baru',
                'created_at'=> Carbon::now()->subDays(3),
            ],

            // ===== DEWI (2 saran) =====
            [
                'user_id'  => $dewi->id,
                'isi_saran'=> 'Bagaimana kalau diadakan program pelajaran Alkitab online atau podcast renungan harian yang bisa diakses jemaat kapan saja? Ini akan sangat membantu jemaat yang sibuk untuk tetap bertumbuh dalam firman Tuhan di tengah padatnya aktivitas sehari-hari.',
                'status'   => 'ditindaklanjuti',
                'created_at'=> Carbon::now()->subDays(55),
            ],
            [
                'user_id'  => $dewi->id,
                'isi_saran'=> 'Mohon perhatian terhadap kebersihan toilet gereja terutama yang ada di lantai dasar. Beberapa kali saya menemukan kondisi yang kurang bersih dan persediaan sabun tangan habis. Kebersihan fasilitas umum sangat penting untuk kenyamanan semua jemaat yang datang beribadah.',
                'status'   => 'baru',
                'created_at'=> Carbon::now()->subDays(1),
            ],

            // ===== AGUS (2 saran) =====
            [
                'user_id'  => $agus->id,
                'isi_saran'=> 'Saya mengusulkan untuk membuat aplikasi mobile gereja yang memuat jadwal ibadah, berita terkini, pengumuman, dan fitur persembahan online. Di era digital ini, aplikasi mobile akan sangat memudahkan jemaat untuk tetap terhubung dan mendapatkan informasi terbaru dari gereja.',
                'status'   => 'dibaca',
                'created_at'=> Carbon::now()->subDays(25),
            ],
            [
                'user_id'  => $agus->id,
                'isi_saran'=> 'Perlu ada peningkatan sistem sound di gedung serbaguna. Saat acara besar, suara di bagian belakang ruangan sering tidak terdengar jelas dan ada gema yang mengganggu. Mungkin bisa dipertimbangkan untuk melakukan evaluasi dan upgrade sistem audio agar semua jemaat bisa mendengar dengan baik.',
                'status'   => 'baru',
                'created_at'=> Carbon::now()->subHours(6),
            ],
        ];

        foreach ($saranList as $item) {
            Saran::create($item);
        }

        $this->command->info('✅ SaranSeeder: 10 saran dari 5 jemaat selesai.');
    }
}