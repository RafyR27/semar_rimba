# SEMAR RIMBA — Website Company Profile & CMS

Organisasi Mahasiswa Pecinta Alam  
Politeknik STIA LAN Bandung

**Disusun oleh Kelompok 2 — Kelas 5E**  
Muhamad Rafy Ramadhan, Raihan Febriahdi, Ridho Arazisyah, Adzki Syauki Nurfalah, Tantawi Shafa Saadilah Simatupang, Aditya Anugrah Pangestu.

---

## 1. Deskripsi Project

**SEMAR RIMBA** adalah aplikasi web Company Profile dan Sistem Manajemen Konten (*Content Management System*) berbasis Laravel untuk Unit Kegiatan Mahasiswa Pecinta Alam SEMAR RIMBA Politeknik STIA LAN Bandung.

Aplikasi ini menyajikan halaman publik informasi organisasi (profil, sejarah, visi-misi, divisi/matra, kepengurusan, galeri, kegiatan, dan berita) sekaligus panel CMS internal berbasis peran (`admin`, `staff`, `penulis`) dengan alur editorial terstruktur (`draft` → `review` → `published` → `archived`).

---

## 2. Fitur Utama

### Halaman Publik
- **Beranda (`/`):** Hero banner dinamis, profil singkat organisasi, pengenalan divisi/matra, rangkaian kegiatan terbaru, berita terbaru, dan tautan media sosial.
- **Tentang Kami (`/tentang`):** Sejarah, visi, misi, struktur divisi/pengurus, dan informasi kontak sekretariat.
- **Kegiatan (`/kegiatan` & `/kegiatan/{slug}`):** Daftar dan detail laporan kegiatan (serta pratinjau terbatas bagi pengguna berwenang sebelum berstatus `published`).
- **Berita (`/berita` & `/berita/{slug}`):** Daftar dan detail artikel berita organisasi dengan dukungan tampilan *rich text*.

### Panel CMS Internal
- **Autentikasi & Hak Akses Berbasis Peran (`admin`, `staff`, `penulis`):** Login menggunakan Laravel Fortify dengan pengecekan status aktif akun serta pembatasan route dan kepemilikan data per peran.
- **Dashboard per Peran:**
  - **Admin (`/admin/dashboard`):** Ringkasan total pengguna (aktif/nonaktif dan per peran), antrean konten menunggu `review`, statistik status Kegiatan dan Berita non-draft, data Divisi, Pengurus aktif, Galeri, Hero Banner, serta konten non-draft terbaru.
  - **Staff (`/staff/dashboard`):** Ringkasan operasional editorial (antrean `review`, statistik status Kegiatan dan Berita, Divisi, Pengurus aktif, Galeri, Hero Banner, dan daftar konten terbaru untuk ditinjau) tanpa akses ke data manajemen pengguna.
  - **Penulis (`/penulis/dashboard`):** Ringkasan statistik dan daftar konten yang dibatasi khusus untuk karya milik penulis yang login (`user_id`), mencakup rincian status (`draft`, `review`, `published`, `archived`) serta jumlah konten yang dibuat hari ini dan bulan ini.
- **Manajemen Konten & Organisasi:** Pengelolaan Pengguna (`admin`), Profil & Kontak Organisasi (`staff`), Hero Banner, Galeri, Divisi, Pengurus, Berita (dengan Tiptap Editor), dan Kegiatan.
- **Unggah Dokumen Pendukung Kegiatan:** Mendukung lampiran berkas opsional pada Kegiatan (`PDF`, `DOC`, `DOCX`, `JPG`, `PNG`, maksimal 5 MB) yang disimpan pada disk privat Laravel (`storage/app/private/activity-documents`) dengan rute unduhan terproteksi per peran/kepemilikan serta pembersihan file lama otomatis saat diganti atau dihapus.
- **Laporan & Export Excel (`.xlsx`):** Rekap Kegiatan dan Berita dengan filter rentang tanggal, jenis konten, dan status sesuai kewenangan peran, serta ekspor ke file Excel (`.xlsx`) menggunakan OpenSpout dengan hasil ekspor yang mengikuti filter aktif.

---

## 3. Tech Stack

- **Backend:** PHP `^8.3`, Laravel `^13.17`, Laravel Fortify `^1.37.2`
- **Frontend & UI:** Livewire `^4.1`, Livewire Flux `^2.13.1`, Tailwind CSS `^4.0.7`, Vite `^8.0.0`, Tiptap `^3.35.0`, Swiper `^14.3.0`
- **Penyimpanan & Ekspor:**
  - `cloudinary/cloudinary_php` `^3.3` (penyimpanan gambar publik)
  - Laravel Filesystem `local` disk (penyimpanan dokumen kegiatan privat)
  - `openspout/openspout` `^5.15` (ekspor laporan `.xlsx`)
- **Pengujian & Kualitas Kode:** Pest `^5.3`, Laravel Pint `^1.27`, Larastan / PHPStan `^3.9` (level 7)

---

## 4. Prasyarat Instalasi

- **PHP:** `>= 8.3` dengan ekstensi aktif `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `gd`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo_sqlite` (atau `pdo_mysql`), `session`, `tokenizer`, `xml`, `xmlwriter`, `zip`.
- **Composer:** versi 2.x.
- **Node.js & npm:** Node.js `>= 20.x` dan npm `>= 10.x`.
- **Database:** SQLite 3 (bawaan) atau MySQL / MariaDB.

---

## 5. Instalasi & Konfigurasi

### 1. Clone Repository & Pasang Dependency

```bash
git clone https://github.com/RafyR27/semar_rimba.git
cd semar_rimba
composer install
npm install
npm run build
```

### 2. Konfigurasi `.env` & Application Key

Salin `.env.example` menjadi `.env`, lalu buat *application key*:

```bash
cp .env.example .env
php artisan key:generate
```

Ringkasan konfigurasi utama pada `.env`:
- `APP_NAME` & `APP_URL`: Nama aplikasi dan URL lokal (bawaan `http://localhost:8000`).
- `DB_CONNECTION`: Bawaan `sqlite` (atau atur kredensial database Anda sendiri jika menggunakan MySQL/PostgreSQL).
- `FILESYSTEM_DISK`: Bawaan `local` untuk menyimpan dokumen pendukung kegiatan secara privat di `storage/app/private`.
- `CLOUDINARY_URL`: Variabel opsional untuk mengaktifkan unggah gambar baru ke layanan Cloudinary. Fitur dashboard, laporan, ekspor Excel, dan unggah dokumen kegiatan privat tetap berfungsi tanpa konfigurasi ini.

### 3. Setup Database, Migration & Seeder

Buat file database SQLite (jika menggunakan konfigurasi SQLite bawaan):

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

---

## 6. Menjalankan Aplikasi

Jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Untuk pengembangan tampilan secara aktif, jalankan build watcher Vite pada terminal terpisah:

```bash
npm run dev
```

Aplikasi dapat diakses di `http://localhost:8000`.

---

## 7. Akun Uji (Khusus Pengujian Lokal)

Setelah menjalankan `php artisan migrate --seed`, tersedia 3 akun demo (masing-masing mewakili satu peran) untuk pengujian pada environment lokal melalui halaman `/login`:

| Peran (`role`) | Email | Password | Dashboard |
| :--- | :--- | :--- | :--- |
| `admin` | `admin@semarrimba.test` | `password123` | `/admin/dashboard` |
| `staff` | `staff@semarrimba.test` | `password123` | `/staff/dashboard` |
| `penulis` | `penulis@semarrimba.test` | `password123` | `/penulis/dashboard` |


## 8. Menjalankan Test & Pemeriksaan Kode

```bash
# Menjalankan test suite (Pest)
vendor/bin/pest

# Memeriksa format kode (Laravel Pint)
composer run lint:check

# Memeriksa analisis statis (PHPStan Level 7)
composer run types:check
```
