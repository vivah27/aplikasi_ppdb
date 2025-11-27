# Aplikasi PPDB

Repository ini berisi aplikasi pendaftaran peserta didik baru (PPDB) berbasis Laravel.

## Ringkasan singkat
- Framework: Laravel
- Database: MySQL (direkomendasikan untuk development dan production)
- Storage: Local disk untuk environment development; gunakan S3 atau storage terprotect di production
- Testing: Pest / PHPUnit

## Docker (MySQL) — Panduan singkat
Jika Anda ingin menjalankan database MySQL menggunakan Docker, ikuti langkah ini.

1. Pastikan Anda menginstal Docker Desktop (Windows) dan sudah menjalankan Docker.

2. File `docker-compose.yml` sudah tersedia di root proyek. Konfigurasi default:

- DB_HOST: `127.0.0.1`
- DB_PORT: `3306`
- DB_DATABASE: `aplikasi_ppdb`
- DB_USERNAME: `appuser`
- DB_PASSWORD: `app_password_here`

3. Contoh perintah (PowerShell):

```powershell
# Di direktori proyek
docker compose up -d
# Tunggu beberapa detik agar MySQL siap
```

4. File `.env.docker` telah dibuat. Untuk beralih sementara ke konfigurasi Docker, salin:

```powershell
Copy-Item .env .env.backup
Copy-Item .env.docker .env
```

Untuk mengembalikan `.env` asli:

```powershell
Move-Item -Force .env.backup .env
```

5. Jalankan migrasi & seeder:

```powershell
php artisan migrate --force
php artisan db:seed --force
```

6. Jika Anda menggunakan CI atau environment test, perbarui `.env.testing` agar menunjuk ke database test.

## Skrip helper PowerShell (Windows)

Di `scripts/` ada dua skrip PowerShell yang dibuat untuk mempermudah pengaturan lokal pada Windows:

- `scripts/use-docker-env.ps1` — swap `.env` dengan `.env.docker` (dan backup `.env` ke `.env.backup`).
	- Contoh: `.\\scripts\\use-docker-env.ps1 -action use` akan menyalin `.env.docker` menjadi `.env`.
	- `-action restore` akan mengembalikan `.env` dari `.env.backup`.

- `scripts/setup-docker-windows.ps1` — jika Docker Desktop sudah terpasang, skrip ini akan menjalankan `docker compose up -d`, menunggu MySQL siap, lalu menjalankan `php artisan migrate --force` dan `php artisan db:seed --force`.
	- Jalankan dari root proyek: `.\\scripts\\setup-docker-windows.ps1`

Catatan: skrip ini hanya helper — pastikan Anda memahami apa yang dijalankan sebelum mengeksekusi pada mesin development.

## Instalasi Docker Desktop (Windows) singkat
1. Kunjungi: https://www.docker.com/get-started
2. Pilih Docker Desktop untuk Windows, unduh dan jalankan installer.
3. Aktifkan WSL2 jika diminta (direkomendasikan) dan restart komputer jika perlu.
4. Buka PowerShell dan jalankan `docker version` untuk verifikasi.

## Menjalankan test
- Jalankan seluruh test suite:

```powershell
php artisan test
```

- Untuk menjalankan test tertentu (contoh BiodataTest):

```powershell
php artisan test --filter=BiodataTest
```

## Catatan
- Docker tidak terpasang di beberapa mesin developer; file `.env.docker` dan `docker-compose.yml` disediakan agar mudah konsisten antara developer.
- Jangan commit file `.env` ke repo. `.env.docker` hanya contoh kredensial development.

