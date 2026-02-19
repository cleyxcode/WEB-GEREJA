# 📖 Dokumentasi Sistem Web Betesda
**Versi:** 1.0 &nbsp;|&nbsp; **Tanggal:** Februari 2026 &nbsp;|&nbsp; **Bahasa:** Indonesia

> [!NOTE]
> Dokumen ini dibuat khusus untuk pihak gereja/klien yang ingin memahami cara kerja sistem website tanpa harus mengerti kode pemrograman. Setiap bagian dijelaskan dengan bahasa yang mudah dipahami.

---

## 🗂️ Daftar Isi
1. [Gambaran Umum Sistem](#gambaran-umum)
2. [Controllers – Logika & Proses](#controllers)
3. [Views – Tampilan Halaman](#views)
4. [Models – Pengolahan Data](#models)
5. [Database – Penyimpanan Data](#database)
6. [Panel Admin (Filament)](#panel-admin)

---

## 🏛️ Gambaran Umum Sistem {#gambaran-umum}

Website Betesda adalah sistem informasi gereja berbasis web yang memiliki **dua sisi utama**:

| Sisi | Untuk Siapa | Fungsi |
|------|-------------|--------|
| **Frontend (Halaman Publik)** | Jemaat & pengunjung | Melihat berita, jadwal, daftar sakramen, kirim saran |
| **Panel Admin** | Pengurus/majelis gereja | Mengelola semua data: berita, jadwal, keuangan, pendaftaran, dll. |

Sistem ini memiliki **dua jenis pengguna**:
- 👤 **Jemaat** – mendaftar sendiri, bisa lihat berita, jadwal, laporan keuangan, dan mengajukan pendaftaran sakramen
- 🔑 **Admin** – diberikan oleh pengurus, bisa mengakses seluruh panel manajemen

---

## ⚙️ Bagian 1: Controllers – Logika & Proses {#controllers}

> **Apa itu Controller?**
> Bayangkan Controller sebagai "pelayan" di restoran. Saat Anda memesan makanan (klik tombol), pelayan (controller) menerima pesanan, mengambil dari dapur (database), lalu menyajikannya di meja (tampilan halaman). Controller adalah otak di balik setiap aksi yang terjadi di website.

---

### 🔐 1. AuthController — Otentikasi Pengguna

**File:** `app/Http/Controllers/Frontend/AuthController.php`

Controller ini mengurus semua hal yang berkaitan dengan **masuk, daftar, dan keluar** dari sistem.

#### Fungsi-fungsi di dalamnya:

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `showLogin()` | Menampilkan halaman login. Jika pengguna sudah login, langsung diarahkan ke halaman yang sesuai (admin → panel admin, jemaat → halaman utama) |
| `login()` | Memproses saat pengguna menekan tombol "Masuk". Mengecek email & password. Jika admin → diarahkan ke panel admin. Jika jemaat → ke halaman beranda |
| `showRegister()` | Menampilkan halaman formulir pendaftaran akun baru |
| `register()` | Memproses data pendaftaran akun baru. Akun yang didaftarkan sendiri selalu berstatus "jemaat" (bukan admin). Langsung login otomatis setelah berhasil daftar |
| `logout()` | Mengakhiri sesi login pengguna dan mengarahkan kembali ke halaman login |

> [!IMPORTANT]
> **Keamanan:** Password harus minimal 8 karakter. Email harus unik (tidak bisa duplikat). Admin tidak bisa dibuat lewat formulir pendaftaran biasa — harus dibuat langsung dari panel admin.

---

### 📰 2. BeritaController — Manajemen Berita

**File:** `app/Http/Controllers/Frontend/BeritaController.php`

Controller ini mengurus tampilan **daftar berita dan detail berita** gereja.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menampilkan daftar semua berita, 9 berita per halaman. Mendukung **fitur pencarian** berdasarkan judul atau isi berita |
| `show($id)` | Menampilkan isi lengkap satu berita tertentu, beserta 3 berita lainnya sebagai rekomendasi di bagian bawah |

---

### 🖼️ 3. GaleriController — Galeri Foto

**File:** `app/Http/Controllers/Frontend/GaleriController.php`

Controller ini menampilkan **galeri foto jemaat** yang diambil dari data pendaftaran sakramen yang sudah disetujui.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menampilkan foto-foto dari jemaat yang pendaftarannya sudah disetujui admin, 12 foto per halaman. Bisa dicari berdasarkan nama atau disaring berdasarkan jenis layanan (baptis/sidi/nikah) |

> [!NOTE]
> Galeri tidak diisi manual. Foto tampil otomatis dari data pendaftaran sakramen yang statusnya **"Disetujui"** oleh admin.

---

### 🏠 4. HomeController — Halaman Beranda

**File:** `app/Http/Controllers/Frontend/HomeController.php`

Controller ini menyiapkan semua data yang ditampilkan di **halaman utama** website.

| Data yang Ditampilkan | Penjelasan |
|----------------------|------------|
| Statistik total jemaat | Jumlah akun jemaat yang terdaftar |
| Jadwal ibadah mendatang | Berapa jadwal yang belum lewat |
| Berita bulan ini | Jumlah berita yang diterbitkan bulan ini |
| Saran belum dibaca | Jumlah saran jemaat yang belum ditinjau admin |
| 3 jadwal ibadah terdekat | Jadwal ibadah yang paling dekat dari hari ini |
| 3 berita terbaru | Berita terbaru yang diterbitkan |
| 6 foto galeri terbaru | Foto dari pendaftaran terbaru yang sudah disetujui |

---

### 🗓️ 5. JadwalController — Jadwal Ibadah & Liturgi

**File:** `app/Http/Controllers/Frontend/JadwalController.php`

Controller ini mengurus **jadwal ibadah** dan file liturgi yang bisa diunduh.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menampilkan daftar jadwal ibadah yang belum lewat, diurutkan dari yang paling dekat. Bisa disaring per bulan dan dicari berdasarkan petugas atau tempat. Menampilkan 9 jadwal per halaman |
| `show($id)` | Menampilkan rincian lengkap satu jadwal ibadah tertentu, termasuk teks liturgi |
| `downloadLiturgi($id)` | Memungkinkan pengguna mengunduh file liturgi (PDF/Word) dari jadwal ibadah tertentu |

---

### 💰 6. KeuanganController — Laporan Keuangan

**File:** `app/Http/Controllers/Frontend/KeuanganController.php`

Controller ini menampilkan **laporan keuangan gereja** secara transparan kepada jemaat.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menghitung dan menampilkan: total pemasukan, total pengeluaran, saldo kas gereja, serta persentase perubahan dibanding bulan lalu. Daftar transaksi bisa disaring per bulan atau jenis (pemasukan/pengeluaran) dan dicari berdasarkan keterangan |
| `export()` | Fitur ekspor data ke Excel (saat ini masih dalam tahap pengembangan) |

---

### 📋 7. PendaftaranController — Pendaftaran Sakramen

**File:** `app/Http/Controllers/Frontend/PendaftaranController.php`

Controller ini mengurus **pendaftaran layanan sakramen** seperti baptis, sidi, dan pemberkatan nikah.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menampilkan riwayat pendaftaran milik pengguna yang sedang login. Bisa dicari berdasarkan jenis atau nama |
| `store()` | Memproses pengajuan pendaftaran baru. Validasi: nama wajib diisi, jenis harus salah satu dari (baptis/sidi/nikah), tanggal minimal 2 minggu dari hari ini, foto maksimal 2MB. Foto disimpan di server secara otomatis |
| `destroy($id)` | Membatalkan pendaftaran yang masih berstatus **"Pending"**. Pendaftaran yang sudah disetujui/ditolak tidak bisa dibatalkan |

---

### 👤 8. ProfileController — Kelola Profil

**File:** `app/Http/Controllers/Frontend/ProfileController.php`

Controller ini mengurus **pengelolaan profil pribadi** pengguna.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menampilkan halaman profil dengan data pengguna yang sedang login |
| `update()` | Menyimpan perubahan data profil (nama, email, nomor HP, alamat) |
| `updatePassword()` | Mengganti password. Harus memasukkan password lama yang benar terlebih dahulu sebelum bisa menggantinya |

---

### 💬 9. SaranController — Kirim Saran

**File:** `app/Http/Controllers/Frontend/SaranController.php`

Controller ini mengurus **pengiriman saran/masukan** dari jemaat kepada gereja.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `index()` | Menampilkan riwayat semua saran yang pernah dikirimkan oleh pengguna yang sedang login |
| `store()` | Mengirim saran baru. Minimal 10 karakter, maksimal 1000 karakter. Saran baru otomatis berstatus "Baru" |

---

### 🔑 10. PasswordResetController — Reset Password

**File:** `app/Http/Controllers/Frontend/PasswordResetController.php`

Controller ini mengurus proses **pemulihan password** yang terlupakan melalui email.

| Fungsi | Penjelasan Sederhana |
|--------|----------------------|
| `showForgotPassword()` | Menampilkan halaman "Lupa Password" dengan formulir input email |
| `sendResetLink()` | Mengirim tautan reset password ke email yang dimasukkan. Sistem akan memverifikasi apakah email terdaftar |
| `showResetPassword()` | Menampilkan formulir reset password setelah pengguna mengklik tautan dari email |
| `resetPassword()` | Menyimpan password baru. Password minimal 8 karakter dan harus dikonfirmasi ulang |

---

## 🖥️ Bagian 2: Views – Tampilan Halaman {#views}

> **Apa itu View?**
> View adalah tampilan visual yang dilihat pengguna di browser. Jika Controller adalah "dapur", maka View adalah "piring sajian" yang tampil di layar.

---

### 🔐 Folder: `auth/` — Halaman Otentikasi

| File | Halaman | Fungsi |
|------|---------|--------|
| `login.blade.php` | Halaman Login | Formulir masuk dengan email & password. Ada opsi "Ingat Saya" dan tautan ke halaman lupa password |
| `register.blade.php` | Halaman Daftar | Formulir pendaftaran akun jemaat baru: nama lengkap, email, password, nomor HP (opsional), dan alamat (opsional) |
| `forgot-password.blade.php` | Lupa Password | Formulir untuk memasukkan email agar tautan reset dikirimkan |
| `reset-password.blade.php` | Reset Password | Formulir untuk memasukkan password baru setelah mengklik tautan dari email |

---

### 📰 Folder: `berita/` — Halaman Berita

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Daftar Berita | Menampilkan semua berita dalam format kartu/grid. Ada kolom pencarian. Dilengkapi navigasi halaman (pagination) |
| `show.blade.php` | Detail Berita | Menampilkan judul, isi lengkap, gambar, tanggal, dan nama pembuat berita. Di bagian bawah ada "Berita Lainnya" |

---

### 🖼️ Folder: `galeri/` — Halaman Galeri

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Galeri Foto | Menampilkan foto jemaat dari pendaftaran yang disetujui dalam format grid. Bisa disaring berdasarkan jenis layanan atau dicari berdasarkan nama |

---

### 🗓️ Folder: `jadwal/` — Halaman Jadwal Ibadah

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Daftar Jadwal | Menampilkan jadwal ibadah mendatang. Ada filter bulan, kolom pencarian, dan kartu "Jadwal Paling Dekat" yang ditampilkan di atas. Setiap kartu memiliki tombol unduh liturgi jika tersedia |
| `show.blade.php` | Detail Jadwal | Menampilkan rincian lengkap satu jadwal: tanggal, waktu, tempat, petugas, teks liturgi, dan tombol unduh file liturgi |

---

### 💰 Folder: `keuangan/` — Halaman Laporan Keuangan

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Laporan Keuangan | Menampilkan ringkasan statistik (total pemasukan, pengeluaran, saldo) dan tabel daftar transaksi. Bisa disaring per bulan dan jenis transaksi. Ada tombol ekspor (dalam pengembangan) |

---

### 📋 Folder: `pendaftaran/` — Halaman Pendaftaran Sakramen

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Pendaftaran Sakramen | Menampilkan riwayat pendaftaran sakramen milik pengguna serta formulir pengajuan baru. Pengguna bisa memilih jenis (Baptis/Sidi/Nikah), tanggal pelaksanaan, dan mengunggah foto. Pendaftaran yang masih "Pending" bisa dibatalkan |

---

### 👤 Folder: `profile/` — Halaman Profil

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Profil Pengguna | Menampilkan dan memungkinkan pengeditan data diri (nama, email, nomor HP, alamat). Terdapat juga tab/bagian terpisah untuk mengganti password |

---

### 💬 Folder: `saran/` — Halaman Saran

| File | Halaman | Fungsi |
|------|---------|--------|
| `index.blade.php` | Kotak Saran | Formulir untuk mengirim saran/masukan kepada gereja. Di bawahnya ada riwayat saran yang pernah dikirim beserta statusnya (Baru/Dibaca/Ditindaklanjuti) |

---

### 🧩 Folder: `layouts/` — Template Kerangka Halaman

| File | Fungsi |
|------|--------|
| `app.blade.php` | Kerangka utama seluruh halaman (berisi `<head>`, CSS, JS). Semua halaman lain "dimasukkan" ke dalam template ini |
| `navbar.blade.php` | Menu navigasi di bagian atas halaman. Menampilkan nama pengguna jika sudah login dan tombol logout |
| `footer.blade.php` | Bagian bawah halaman berisi informasi gereja, kontak, dan hak cipta |

---

### 📄 File Lainnya

| File | Fungsi |
|------|--------|
| `home.blade.php` | Halaman utama/beranda yang menampilkan statistik, jadwal terdekat, berita terbaru, dan galeri foto |
| `pagination.blade.php` | Komponen navigasi halaman (tombol "Sebelumnya", "1", "2", "Berikutnya") yang digunakan di halaman yang memiliki banyak data |

---

## 🗃️ Bagian 3: Models – Pengolahan Data {#models}

> **Apa itu Model?**
> Model adalah "jembatan" antara aplikasi dan database. Ia tahu tabel mana yang digunakan, data apa yang boleh disimpan, dan bagaimana satu data berhubungan dengan data lainnya.

---

### 👤 User.php — Data Pengguna

**Tabel Database:** `users`

Model ini merepresentasikan **semua pengguna** sistem, baik admin maupun jemaat.

**Data yang disimpan:**
- `name` — Nama lengkap pengguna
- `email` — Alamat email (unik, tidak boleh sama)
- `password` — Password (disimpan terenkripsi)
- `role` — Peran: `admin` atau `jemaat`
- `no_hp` — Nomor handphone (bisa kosong)
- `alamat` — Alamat rumah (bisa kosong)

**Relasi dengan data lain:**
- Satu User bisa punya **banyak Pendaftaran** (baptis/sidi/nikah)
- Satu User bisa punya **banyak Saran** yang pernah dikirim

> [!NOTE]
> Hanya pengguna dengan `role = 'admin'` yang bisa mengakses panel manajemen. Password reset menggunakan notifikasi email khusus.

---

### 📰 Berita.php — Data Berita

**Tabel Database:** `berita`

Model ini merepresentasikan **setiap artikel berita** yang diterbitkan gereja.

**Data yang disimpan:**
- `judul` — Judul berita
- `isi` — Isi/konten berita (bisa berformat teks kaya/HTML)
- `gambar` — Nama file gambar (bisa kosong)
- `created_by` — ID pengguna yang membuat berita

**Relasi:** Setiap berita terhubung ke satu User (pembuatnya) melalui `created_by`.

---

### 🗓️ JadwalIbadah.php — Data Jadwal Ibadah

**Tabel Database:** `jadwal_ibadah`

Model ini merepresentasikan **setiap jadwal ibadah** yang dijadwalkan gereja.

**Data yang disimpan:**
- `tanggal` — Tanggal ibadah (selalu hari Minggu)
- `waktu` — Jam pelaksanaan ibadah
- `tempat` — Lokasi/ruang ibadah
- `petugas_ibadah` — Nama petugas yang bertugas
- `liturgi_text` — Teks liturgi/tatacara ibadah (bisa kosong)
- `liturgi_file` — File dokumen liturgi yang bisa diunduh (bisa kosong)
- `created_by` — ID pengguna yang membuat jadwal

**Relasi:** Setiap jadwal terhubung ke satu User (pembuatnya).

---

### 💰 LaporanKeuangan.php — Data Keuangan

**Tabel Database:** `laporan_keuangan`

Model ini merepresentasikan **setiap transaksi keuangan** gereja.

**Data yang disimpan:**
- `tanggal` — Tanggal transaksi
- `jenis` — Jenis transaksi: `pemasukan` atau `pengeluaran`
- `jumlah` — Nominal uang (disimpan dengan presisi 2 desimal)
- `keterangan` — Penjelasan transaksi (misal: "Persembahan Minggu", "Listrik")
- `created_by` — ID admin yang mencatat

**Relasi:** Setiap laporan terhubung ke satu User (admin pencatat).

---

### 📋 Pendaftaran.php — Data Pendaftaran Sakramen

**Tabel Database:** `pendaftaran`

Model ini merepresentasikan **setiap pengajuan pendaftaran sakramen** dari jemaat.

**Data yang disimpan:**
- `user_id` — Akun jemaat yang mendaftar
- `nama` — Nama lengkap yang didaftarkan
- `jenis` — Jenis layanan: `baptis`, `sidi`, atau `nikah`
- `tanggal_daftar` — Tanggal pelaksanaan yang diinginkan
- `foto` — Foto dokumen pendukung (bisa kosong)
- `catatan` — Catatan tambahan dari pemohon (bisa kosong)
- `status` — Status pendaftaran: `pending`, `disetujui`, atau `ditolak`

**Relasi:** Setiap pendaftaran terhubung ke satu User (jemaat yang mendaftar).

---

### 💬 Saran.php — Data Saran

**Tabel Database:** `saran`

Model ini merepresentasikan **setiap pesan saran/masukan** yang dikirim jemaat.

**Data yang disimpan:**
- `user_id` — Akun jemaat pengirim saran
- `isi_saran` — Teks/isi saran yang dikirim
- `status` — Status saran: `baru`, `dibaca`, atau `ditindaklanjuti`

**Relasi:** Setiap saran terhubung ke satu User (jemaat pengirim).

---

## 🗄️ Bagian 4: Database – Penyimpanan Data {#database}

> **Apa itu Database?**
> Database adalah "lemari arsip digital" tempat semua data disimpan secara terstruktur. Setiap "laci" disebut **tabel**, dan setiap baris data di dalam tabel disebut **record**.

---

### 📊 Tabel: `users` — Data Pengguna
**File Migrasi:** `0001_01_01_000000_create_users_table.php` + `2026_02_17_001134_add_role_to_users_table.php`

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | Angka unik | Nomor identitas pengguna (otomatis) |
| `name` | Teks | Nama lengkap |
| `email` | Teks (unik) | Alamat email – tidak boleh sama dengan pengguna lain |
| `email_verified_at` | Tanggal & waktu | Kapan email diverifikasi (bisa kosong) |
| `password` | Teks | Password yang sudah dienkripsi |
| `role` | Pilihan | `admin` atau `jemaat` (default: `jemaat`) |
| `no_hp` | Teks | Nomor handphone (bisa kosong) |
| `alamat` | Teks panjang | Alamat lengkap (bisa kosong) |
| `remember_token` | Teks | Token untuk fitur "Ingat Saya" |
| `created_at` / `updated_at` | Tanggal & waktu | Otomatis dicatat oleh sistem |

---

### 📊 Tabel: `password_reset_tokens` — Token Reset Password
**File Migrasi:** `0001_01_01_000000_create_users_table.php`

Tabel sementara yang menyimpan kode unik untuk proses reset password melalui email. Kode ini bersifat satu kali pakai.

| Kolom | Keterangan |
|-------|------------|
| `email` | Email pengguna yang meminta reset |
| `token` | Kode unik yang dikirim ke email |
| `created_at` | Waktu permintaan dibuat |

---

### 📊 Tabel: `sessions` — Sesi Login
**File Migrasi:** `0001_01_01_000000_create_users_table.php`

Menyimpan informasi sesi pengguna yang sedang login (agar pengguna tidak perlu login ulang setiap membuka halaman baru).

---

### 📊 Tabel: `berita` — Data Berita
**File Migrasi:** `2026_02_17_000850_create_beritas_table.php`

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | Angka unik | Nomor identitas berita |
| `judul` | Teks | Judul artikel berita |
| `isi` | Teks panjang | Isi lengkap berita |
| `gambar` | Teks | Nama/path file gambar (bisa kosong) |
| `created_by` | Angka | Merujuk ke `id` di tabel `users` (siapa yang membuat) |
| `created_at` / `updated_at` | Tanggal & waktu | Otomatis dicatat sistem |

> [!NOTE]
> Jika admin yang membuat berita dihapus, berita yang dibuatnya ikut terhapus secara otomatis (`cascade delete`).

---

### 📊 Tabel: `jadwal_ibadah` — Data Jadwal Ibadah
**File Migrasi:** `2026_02_17_000850_create_jadwal_ibadahs_table.php`

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | Angka unik | Nomor identitas jadwal |
| `tanggal` | Tanggal | Tanggal pelaksanaan (harus hari Minggu) |
| `waktu` | Waktu | Jam mulai ibadah |
| `tempat` | Teks | Lokasi ibadah |
| `petugas_ibadah` | Teks | Nama petugas yang bertugas |
| `liturgi_text` | Teks panjang | Susunan liturgi dalam format teks (bisa kosong) |
| `liturgi_file` | Teks | Nama/path file liturgi PDF/Word (bisa kosong) |
| `created_by` | Angka | Merujuk ke `id` di tabel `users` |
| `created_at` / `updated_at` | Tanggal & waktu | Otomatis dicatat sistem |

---

### 📊 Tabel: `pendaftaran` — Data Pendaftaran Sakramen
**File Migrasi:** `2026_02_17_000850_create_pendaftarans_table.php`

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | Angka unik | Nomor identitas pendaftaran |
| `user_id` | Angka | Merujuk ke `id` di tabel `users` (siapa yang mendaftar) |
| `nama` | Teks | Nama lengkap yang didaftarkan |
| `jenis` | Pilihan | `baptis`, `sidi`, atau `nikah` |
| `tanggal_daftar` | Tanggal | Tanggal pelaksanaan yang diminta |
| `foto` | Teks | Nama/path file foto (bisa kosong) |
| `catatan` | Teks panjang | Catatan tambahan dari pemohon (bisa kosong) |
| `status` | Pilihan | `pending` (menunggu), `disetujui`, atau `ditolak` |
| `created_at` / `updated_at` | Tanggal & waktu | Otomatis dicatat sistem |

---

### 📊 Tabel: `laporan_keuangan` — Data Keuangan
**File Migrasi:** `2026_02_17_000851_create_laporan_keuangans_table.php` + `2026_02_17_003118_add_keterangan_to_laporan_keuangan_table.php`

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | Angka unik | Nomor identitas transaksi |
| `tanggal` | Tanggal | Tanggal transaksi keuangan |
| `jenis` | Pilihan | `pemasukan` atau `pengeluaran` |
| `jumlah` | Desimal (15,2) | Nominal uang (mendukung hingga 15 digit, 2 desimal) |
| `keterangan` | Teks panjang | Deskripsi transaksi (bisa kosong) |
| `created_by` | Angka | Merujuk ke `id` di tabel `users` (admin pencatat) |
| `created_at` / `updated_at` | Tanggal & waktu | Otomatis dicatat sistem |

---

### 📊 Tabel: `saran` — Data Saran Jemaat
**File Migrasi:** `2026_02_17_000851_create_sarans_table.php`

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | Angka unik | Nomor identitas saran |
| `user_id` | Angka | Merujuk ke `id` di tabel `users` (pengirim) |
| `isi_saran` | Teks panjang | Isi saran yang dikirimkan |
| `status` | Pilihan | `baru`, `dibaca`, atau `ditindaklanjuti` |
| `created_at` / `updated_at` | Tanggal & waktu | Otomatis dicatat sistem |

---

### 🔗 Diagram Relasi Antar Tabel

```
users (tabel utama)
  │
  ├──→ berita (created_by → users.id)
  │       Satu admin bisa membuat banyak berita
  │
  ├──→ jadwal_ibadah (created_by → users.id)
  │       Satu admin bisa membuat banyak jadwal
  │
  ├──→ laporan_keuangan (created_by → users.id)
  │       Satu admin bisa mencatat banyak transaksi
  │
  ├──→ pendaftaran (user_id → users.id)
  │       Satu jemaat bisa punya banyak pendaftaran sakramen
  │
  └──→ saran (user_id → users.id)
          Satu jemaat bisa mengirim banyak saran
```

---

## 🛡️ Bagian 5: Panel Admin (Filament) {#panel-admin}

> **Apa itu Panel Admin Filament?**
> Panel Admin adalah halaman khusus yang hanya bisa diakses oleh pengurus/admin gereja. Ini adalah "ruang kontrol" untuk mengelola seluruh konten dan aktivitas di website. Diakses melalui alamat: `website.com/admin`

---

### 📰 BeritaResource — Manajemen Berita

**Ikon:** 📰 Surat Kabar | **Menu:** Berita

Admin dapat mengelola seluruh artikel berita gereja dari halaman ini.

#### Fitur yang tersedia:
- ✅ **Buat berita baru** — Formulir dengan judul, isi (editor teks kaya dengan fitur bold, italic, gambar, dll.), dan gambar
- ✅ **Unggah gambar** — Mendukung editor gambar dengan pilihan rasio 16:9, 4:3, atau 1:1. Ukuran maksimal 2MB
- ✅ **Tabel daftar berita** — Menampilkan gambar thumbnail, judul, isi singkat, siapa yang membuat, dan tanggal
- ✅ **Cari & urutkan** — Bisa mencari berdasarkan judul/isi, urutkan berdasarkan tanggal
- ✅ **Lihat, Edit, Hapus** — Setiap baris memiliki tombol aksi
- ✅ **Hapus massal** — Bisa memilih beberapa berita lalu hapus sekaligus

---

### 🗓️ JadwalIbadahResource — Manajemen Jadwal Ibadah

**Ikon:** 📅 Kalender | **Menu:** Jadwal Ibadah

Admin dapat mengelola jadwal ibadah mingguan dari halaman ini.

#### Fitur yang tersedia:
- ✅ **Buat jadwal baru** — Formulir dengan tanggal (hanya Minggu), waktu, tempat, petugas ibadah, teks liturgi, dan unggah file liturgi (PDF/Word, maks 5MB)
- ✅ **Validasi otomatis** — Sistem menolak jika tanggal yang dipilih bukan hari Minggu
- ✅ **Tabel daftar jadwal** — Menampilkan tanggal, waktu, tempat, petugas, dan indikator apakah file liturgi tersedia
- ✅ **Indikator file liturgi** — Ikon hijau jika ada file, merah jika tidak ada
- ✅ **Lihat, Edit, Hapus** — Setiap baris memiliki tombol aksi

---

### 👥 JemaatResource — Manajemen Data Jemaat

**Ikon:** 👥 Grup Pengguna | **Menu:** Jemaat | **Badge:** Jumlah total jemaat terdaftar

Admin dapat melihat dan mengelola semua akun jemaat yang terdaftar.

#### Fitur yang tersedia:
- ✅ **Daftar jemaat** — Menampilkan nama, email (bisa disalin), nomor HP, alamat, dan jumlah riwayat pendaftaran & saran
- ✅ **Tambah jemaat manual** — Admin bisa mendaftarkan jemaat langsung tanpa harus jemaat itu mendaftar sendiri
- ✅ **Edit data jemaat** — Ubah nama, email, nomor HP, alamat, atau ganti password
- ✅ **Filter** — Saring berdasarkan apakah punya nomor HP atau alamat
- ✅ **Pintasan** — Dari halaman daftar jemaat, bisa langsung melihat riwayat pendaftaran atau saran jemaat tersebut
- ✅ **Hapus dengan konfirmasi** — Ada peringatan bahwa data pendaftaran dan saran terkait juga akan ikut terhapus

> [!CAUTION]
> Menghapus akun jemaat akan **menghapus secara permanen** semua data pendaftaran dan saran yang terkait dengan akun tersebut.

---

### 💰 LaporanKeuanganResource — Manajemen Laporan Keuangan

**Ikon:** 💵 Uang | **Menu:** Laporan Keuangan

Admin dapat mencatat dan mengelola semua transaksi keuangan gereja dari halaman ini.

#### Fitur yang tersedia:
- ✅ **Tambah transaksi** — Input tanggal, jenis (Pemasukan/Pengeluaran), jumlah (dalam Rupiah), dan keterangan
- ✅ **Tabel transaksi** — Menampilkan tanggal, jenis (dengan warna berbeda: hijau=pemasukan, merah=pengeluaran), jumlah, dan keterangan
- ✅ **Total otomatis** — Di bagian bawah tabel, jumlah total semua transaksi yang tampil dijumlahkan otomatis
- ✅ **Filter canggih** — Saring berdasarkan jenis transaksi ATAU rentang tanggal (dari tanggal... sampai tanggal...)
- ✅ **Cari** — Cari berdasarkan keterangan transaksi

---

### 📋 PendaftaranResource — Manajemen Pendaftaran Sakramen

**Ikon:** 📋 Clipboard | **Menu:** Pendaftaran | **Badge:** Jumlah pendaftaran yang menunggu (warna kuning)

Admin dapat mengelola dan memproses semua pengajuan pendaftaran sakramen dari jemaat.

#### Fitur yang tersedia:
- ✅ **Daftar pendaftaran** — Menampilkan nama, jenis layanan (dengan warna berbeda), tanggal pelaksanaan, foto, catatan, dan status
- ✅ **Status dengan warna** — Kuning = Pending (menunggu), Hijau = Disetujui, Merah = Ditolak
- ✅ **Setujui / Tolak** — Tombol aksi langsung di setiap baris untuk memproses pendaftaran yang masih "Pending"
- ✅ **Proses massal** — Bisa pilih banyak pendaftaran dan setujui/tolak sekaligus
- ✅ **Filter** — Saring berdasarkan jenis layanan atau status
- ✅ **Notifikasi** — Setiap kali menyetujui/menolak, muncul notifikasi konfirmasi di layar admin

> [!IMPORTANT]
> **Badge kuning** di menu navigasi menunjukkan berapa pendaftaran yang masih "Pending" dan menunggu diproses. Segera tindaklanjuti agar jemaat tidak menunggu terlalu lama.

---

### 💬 SaranResource — Manajemen Saran Jemaat

**Ikon:** 💬 Gelembung Percakapan | **Menu:** Saran | **Badge:** Jumlah saran baru yang belum dibaca

Admin dapat membaca dan merespons saran/masukan dari jemaat di halaman ini.

#### Fitur yang tersedia:
- ✅ **Daftar saran** — Menampilkan nama pengirim, email, isi saran, status, dan tanggal
- ✅ **Status dengan warna** — Biru = Baru, Kuning = Dibaca, Hijau = Ditindaklanjuti
- ✅ **Tandai Dibaca** — Tombol untuk menandai saran sudah dibaca oleh admin
- ✅ **Tandai Ditindaklanjuti** — Tombol untuk menandai saran telah direspons/ditindaklanjuti
- ✅ **Aksi massal** — Bisa menandai banyak saran sekaligus sebagai "Dibaca" atau "Ditindaklanjuti"
- ✅ **Filter** — Saring berdasarkan status saran

> [!IMPORTANT]
> **Badge biru** di menu navigasi menunjukkan berapa saran yang masih "Baru" (belum dibaca). Badge hilang ketika semua saran sudah ditindaklanjuti.

---

## 📌 Ringkasan Alur Kerja Sistem

```
JEMAAT (Frontend)                    ADMIN (Panel Admin)
─────────────────                    ──────────────────
1. Daftar akun baru          ──→     JemaatResource: lihat akun baru
2. Login                      
3. Lihat berita/jadwal        ←──    BeritaResource: buat/edit berita
                              ←──    JadwalIbadahResource: buat/edit jadwal
4. Ajukan pendaftaran sakramen──→    PendaftaranResource: setujui/tolak
5. Lihat laporan keuangan     ←──    LaporanKeuanganResource: input transaksi
6. Kirim saran                ──→    SaranResource: baca & tindaklanjuti
7. Edit profil / ganti pass
```

---

*Dokumentasi ini dibuat secara otomatis berdasarkan kode sumber project. Untuk pertanyaan lebih lanjut, hubungi pengembang sistem.*
