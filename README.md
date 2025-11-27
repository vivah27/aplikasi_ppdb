# Aplikasi PPDB (Penerimaan Peserta Didik Baru)

Repository ini berisi aplikasi PPDB berbasis Laravel yang digunakan untuk mengelola pendaftaran, upload dokumen, verifikasi berkas, dan proses pembayaran.

Fitur utama
- Manajemen pendaftar dan biodata
- Upload, preview, dan verifikasi dokumen (admin)
- Status pendaftaran & verifikasi dokumen
- Form pembayaran, unggah bukti, dan manajemen status pembayaran
- Export laporan dan cetak dokumen (kuitansi, kartu peserta)

Teknologi
- Framework: Laravel
- Database: MySQL
- Testing: Pest / PHPUnit

Persiapan dan requirement
- PHP 8.1+ (direkomendasikan sesuai composer.json)
- Composer
- MySQL (atau gunakan Docker Compose yang disediakan)
- Node.js & npm (untuk build assets / Vite)

Instalasi (singkat)

1. Clone repo dan masuk ke folder proyek:

```powershell
git clone <repo-url>
cd aplikasi_ppdb
```

2. Install dependency PHP dan Javascript:

```powershell
composer install
npm install
npm run build   # atau `npm run dev` untuk development
```

3. Salin file environment dan atur konfigurasi database:

```powershell
Copy-Item .env.example .env
# edit .env sesuai environment lokal Anda (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
```

Database: migrasi & seeder

1. Jalankan migrasi:

```powershell
php artisan migrate
```

2. Seed data awal (roles, status, metode pembayaran, dsb):

```powershell
php artisan db:seed --class=FeatureSeeder
php artisan db:seed --class=StatusPembayaranSeeder
```

Catatan: repository sudah berisi beberapa migration pembaruan dan seeder. Jika struktur tabel lama masih ada, ada migration bantuan (`database/migrations/2025_11_28_010000_cleanup_old_pembayaran_columns.php`) yang memindahkan data legacy sebelum menghapus kolom lama.

Menjalankan aplikasi lokal

```powershell
php artisan serve
# buka http://127.0.0.1:8000
```

Docker (opsional)

Jika ingin menggunakan MySQL via Docker, ada `docker-compose.yml` dan `.env.docker` (contoh). Ringkasan:

```powershell
# jalankan docker compose
docker compose up -d

# lalu swap .env jika perlu (opsional)
Copy-Item .env .env.backup
Copy-Item .env.docker .env

# migrasi dan seed
php artisan migrate --force
php artisan db:seed --force
```

Perhatian: jangan commit file `.env` yang mengandung credential.

Debug & logs
- Logs Laravel: `storage/logs/laravel.log`
- Jika ada error database (kolom tidak ditemukan), cek migrasi terbaru dan jalankan `php artisan migrate`.

Commands berguna
- Jalankan test: `php artisan test`
- Jalankan seeder tertentu: `php artisan db:seed --class=StatusPembayaranSeeder`
- Clear cache config: `php artisan config:clear`

Panduan singkat kontribusi
- Fork repo, buat branch fitur/bugfix, push, dan buka PR. Sertakan deskripsi perubahan.

Kontak / Catatan tambahan
- Proyek ini berisi beberapa migration dan seeder yang mengubah struktur tabel seiring perkembangan. Jika Anda menemukan error saat insert/seed terkait kolom legacy (mis. `nama` pada tabel `pembayaran`), jalankan migrasi cleanup yang sudah disediakan atau hubungi developer untuk langkah backup data.

---

Terima kasih sudah menggunakan aplikasi ini. Jika mau saya sesuaikan README dengan informasi deploy (contoh server, langkah backup, cron job), beri tahu saya detail yang ingin ditambahkan.

