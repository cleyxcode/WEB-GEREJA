<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $beritaList = [
            [
                'judul'      => 'Persiapan Natal 2025: Jadwal Latihan Paduan Suara',
                'isi'        => '<h2>Persiapan Natal 2025</h2><p>Dalam rangka menyambut perayaan Natal 2025, Panitia Natal Gereja Bethesda mengundang seluruh anggota paduan suara untuk mengikuti serangkaian latihan gabungan yang akan dimulai dalam waktu dekat.</p><p>Latihan akan dilaksanakan setiap <strong>Sabtu pukul 16.00 WIB</strong> di <strong>Ruang Serbaguna Lantai 2</strong>. Mohon kehadiran seluruh anggota paduan suara tepat waktu untuk memastikan persiapan berjalan lancar.</p><h3>Jadwal Latihan:</h3><ul><li>Sabtu, 6 Desember 2025 - Latihan perdana & pembagian partitur</li><li>Sabtu, 13 Desember 2025 - Latihan vokal & harmonisasi</li><li>Sabtu, 20 Desember 2025 - Gladi bersih</li><li>Rabu, 24 Desember 2025 - Ibadah Malam Natal</li></ul><p>Untuk informasi lebih lanjut, hubungi koordinator paduan suara Ibu Susanti di nomor 081234567891.</p>',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'judul'      => 'Retreat Pemuda 2025: "Bangkit dan Bersinar"',
                'isi'        => '<h2>Retreat Tahunan Komisi Pemuda</h2><p>Gereja Bethesda dengan bangga mengumumkan penyelenggaraan <strong>Retreat Tahunan Pemuda 2025</strong> dengan tema <em>"Bangkit dan Bersinar"</em>. Acara ini dirancang untuk memperlengkapi para pemuda dalam iman dan karakter Kristiani.</p><h3>Detail Acara:</h3><ul><li><strong>Tanggal:</strong> 14-16 Maret 2025</li><li><strong>Lokasi:</strong> Wisma Puncak Damai, Bogor</li><li><strong>Biaya:</strong> Rp 350.000 (sudah termasuk penginapan & konsumsi)</li></ul><h3>Pendaftaran:</h3><p>Pendaftaran dibuka mulai <strong>1 Februari 2025</strong> dan ditutup pada <strong>28 Februari 2025</strong> atau sampai kuota terpenuhi (max. 60 peserta).</p><p>Daftarkan diri Anda di sekretariat gereja atau hubungi Koordinator Pemuda Sdr. Kevin di 082345678902.</p>',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'judul'      => 'Renungan Mingguan: Kasih yang Memulihkan',
                'isi'        => '<h2>Renungan: Kasih yang Memulihkan</h2><blockquote><em>"Karena begitu besar kasih Allah akan dunia ini, sehingga Ia telah mengaruniakan Anak-Nya yang tunggal, supaya setiap orang yang percaya kepada-Nya tidak binasa, melainkan beroleh hidup yang kekal."</em> - Yohanes 3:16</blockquote><p>Saudara-saudari terkasih dalam Kristus,</p><p>Di tengah kesibukan dan tantangan kehidupan sehari-hari, seringkali kita lupa akan kasih Allah yang tak terbatas. Kasih-Nya bukan sekadar perasaan atau kata-kata, melainkan tindakan nyata yang diwujudkan melalui pengorbanan Yesus Kristus di kayu salib.</p><p>Kasih yang memulihkan adalah kasih yang mampu menyembuhkan luka-luka batin kita, memulihkan hubungan yang rusak, dan memberikan pengharapan di tengah keputusasaan. Kasih ini tersedia bagi setiap kita, tanpa terkecuali.</p><h3>Refleksi:</h3><ol><li>Sudahkah kita merasakan kasih Allah dalam kehidupan sehari-hari?</li><li>Bagaimana kita dapat menyalurkan kasih tersebut kepada sesama?</li><li>Apakah ada hubungan yang perlu dipulihkan dalam hidup kita?</li></ol><p>Mari kita doakan bersama agar kasih Kristus semakin nyata dalam kehidupan kita. Tuhan memberkati.</p><p><em>- Pdt. Yohanes Simatupang</em></p>',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'judul'      => 'Bakti Sosial di Panti Asuhan Kasih Yatim Piatu',
                'isi'        => '<h2>Kegiatan Bakti Sosial Gereja Bethesda</h2><p>Dalam semangat pelayanan dan kasih, <strong>Komisi Sosial Gereja Bethesda</strong> akan mengadakan kegiatan Bakti Sosial di <strong>Panti Asuhan Kasih Yatim Piatu</strong>, Ciputat, Tangerang Selatan.</p><h3>Agenda Kegiatan:</h3><ul><li>Penyerahan bantuan sembako & perlengkapan belajar</li><li>Ibadah bersama anak-anak panti</li><li>Pertunjukan seni & permainan edukatif</li><li>Makan siang bersama</li></ul><h3>Bentuk Donasi yang Dibutuhkan:</h3><ul><li>Sembako (beras, minyak, gula, dll.)</li><li>Pakaian layak pakai (usia 5-17 tahun)</li><li>Perlengkapan sekolah (buku, alat tulis)</li><li>Donasi uang tunai</li></ul><p>Pengumpulan donasi dapat dilakukan di <strong>meja sekretariat gereja</strong> setiap hari Minggu pada jam pelayanan, atau dapat dikirimkan langsung ke kantor gereja.</p><p>Kontak: Koord. Sosial - Ibu Margaretha (083456789013)</p>',
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'judul'      => 'Ibadah Padang Wilayah 3 - Sukacita di Alam Terbuka',
                'isi'        => '<h2>Ibadah Padang Wilayah 3</h2><p>Dengan penuh sukacita, <strong>Pengurus Wilayah 3 Gereja Bethesda</strong> mengundang seluruh jemaat wilayah 3 untuk hadir dalam <strong>Ibadah Padang</strong> yang akan menjadi momen persekutuan yang luar biasa.</p><h3>Detail Acara:</h3><ul><li><strong>Hari/Tanggal:</strong> Minggu, 23 Maret 2025</li><li><strong>Waktu:</strong> Pukul 08.00 - 13.00 WIB</li><li><strong>Tempat:</strong> Taman Bunga Nusantara, Cipanas, Cianjur</li></ul><h3>Rundown Acara:</h3><ol><li>08.00 - Kumpul & Registrasi</li><li>08.30 - Ibadah Padang dipimpin Pdt. Maria Claudia</li><li>10.00 - Makan Siang Bersama</li><li>11.00 - Games & Persekutuan</li><li>12.30 - Penutupan</li></ol><p>Biaya transport: Rp 75.000/orang (sudah termasuk snack & makan siang). Pendaftaran paling lambat <strong>Minggu, 16 Maret 2025</strong>.</p>',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'judul'      => 'Pengumuman: Jadwal Ibadah Pekan Suci 2025',
                'isi'        => '<h2>Jadwal Lengkap Ibadah Pekan Suci 2025</h2><p>Berikut adalah jadwal lengkap rangkaian ibadah <strong>Pekan Suci 2025</strong> yang akan diselenggarakan oleh Gereja Bethesda. Kami mengundang seluruh jemaat untuk hadir dan turut merayakan momen yang paling sakral dalam iman Kristen ini.</p><h3>Rangkaian Ibadah:</h3><table><tr><th>Hari</th><th>Tanggal</th><th>Ibadah</th><th>Waktu</th></tr><tr><td>Minggu</td><td>13 April</td><td>Ibadah Minggu Palma</td><td>07.30 & 09.00</td></tr><tr><td>Kamis</td><td>17 April</td><td>Ibadah Kamis Putih</td><td>18.30</td></tr><tr><td>Jumat</td><td>18 April</td><td>Ibadah Jumat Agung</td><td>08.00 & 15.00</td></tr><tr><td>Sabtu</td><td>19 April</td><td>Ibadah Malam Paskah</td><td>19.00</td></tr><tr><td>Minggu</td><td>20 April</td><td>Ibadah Minggu Paskah</td><td>06.00, 08.00 & 10.00</td></tr></table><p>Untuk ibadah Jumat Agung dan Minggu Paskah, <strong>registrasi kursi diperlukan</strong> mengingat kapasitas gedung. Silakan daftar melalui sekretariat gereja.</p>',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'judul'      => 'Program Sekolah Minggu: Pendaftaran Guru Baru',
                'isi'        => '<h2>Bergabunglah sebagai Guru Sekolah Minggu!</h2><p>Komisi Anak Gereja Bethesda membuka pendaftaran untuk <strong>Guru Sekolah Minggu</strong> tahun pelayanan 2025-2026. Ini adalah kesempatan emas untuk melayani Tuhan melalui pelayanan anak-anak.</p><h3>Persyaratan:</h3><ul><li>Anggota aktif Gereja Bethesda minimal 1 tahun</li><li>Berusia 18-45 tahun</li><li>Memiliki kerinduan melayani anak-anak</li><li>Bersedia mengikuti pelatihan dasar</li></ul><h3>Benefit:</h3><ul><li>Pelatihan pedagogi Alkitab</li><li>Fellowship guru setiap bulan</li><li>Dukungan bahan ajar lengkap</li></ul><p>Pendaftaran dibuka <strong>1-31 Januari 2025</strong>. Formulir tersedia di sekretariat gereja atau dapat diunduh di website resmi gereja.</p><p>Informasi: Koord. Sekolah Minggu - Ibu Rahel (084567890124)</p>',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'judul'      => 'Syukuran HUT Gereja Bethesda ke-45',
                'isi'        => '<h2>HUT Gereja Bethesda ke-45 Tahun</h2><p>Dengan penuh ucapan syukur, kami mengundang seluruh jemaat untuk bersama-sama merayakan <strong>Hari Ulang Tahun Gereja Bethesda yang ke-45</strong>. Sudah 45 tahun Tuhan setia menuntun dan memberkati gereja kita tercinta.</p><h3>Tema: "Setia dalam Kasih, Teguh dalam Iman"</h3><p>Rangkaian perayaan akan berlangsung selama satu minggu penuh, dimulai dari:</p><ul><li><strong>Ibadah Syukur HUT</strong> - dipimpin oleh Pdt. Emeritus Dr. Paulus Sitorus</li><li><strong>Pameran Foto Sejarah Gereja</strong> - menampilkan perjalanan 45 tahun Bethesda</li><li><strong>Konser Pujian</strong> - menampilkan berbagai kelompok musik & paduan suara</li><li><strong>Makan Malam Bersama</strong> - fellowship seluruh jemaat</li><li><strong>Aksi Sosial</strong> - pelayanan di komunitas sekitar gereja</li></ul><p>Mari kita rayakan bersama dan semakin berkomitmen untuk menjadi berkat bagi sesama. Daftarkan diri Anda sekarang untuk makan malam bersama sebelum kursi habis!</p>',
                'created_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($beritaList as $berita) {
            Berita::updateOrCreate(
                ['judul' => $berita['judul']],
                [
                    'judul'      => $berita['judul'],
                    'isi'        => $berita['isi'],
                    'gambar'     => null,
                    'created_by' => $admin->id,
                    'created_at' => $berita['created_at'],
                    'updated_at' => $berita['created_at'],
                ]
            );
        }

        $this->command->info('✅ BeritaSeeder: 8 berita selesai.');
    }
}