# MedisCare — Sistem Informasi Manajemen Rumah Sakit (SIMRS)

Aplikasi manajemen rumah sakit full-stack: pendaftaran, antrean, rekam medis elektronik,
rawat jalan/inap, kamar & bed, resep & obat, laboratorium, radiologi, administrasi &
pembayaran, laporan, notifikasi, dan audit log — dibangun dengan PHP Laravel + MySQL,
mobile-first, dan siap dikembangkan menjadi PWA/aplikasi Android & iOS lewat Capacitor.

> ⚠️ **Status**: prototype pengembangan. Gunakan hanya data fiktif untuk demo. Aplikasi ini
> harus melalui pengujian keamanan, validasi menyeluruh, dan penyesuaian regulasi sebelum
> digunakan untuk operasional rumah sakit sebenarnya.

## 1. Requirements

- PHP 8.2 atau lebih baru, dengan ekstensi: `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`,
  `xml`, `ctype`, `json`, `bcmath`, `gd` (untuk `barryvdh/laravel-dompdf`)
- Composer 2.x
- Node.js 18+ dan NPM
- MySQL 8.0+ (atau MariaDB 10.6+)
- Git

## 2. Clone Project

```bash
git clone <url-repository-anda> mediscare
cd mediscare
```

Jika Anda menerima proyek ini sebagai arsip ZIP (bukan clone git), ekstrak arsip lalu masuk
ke direktori `mediscare`.

## 3. Composer Install

```bash
composer install
```

> Proyek ini dibuat menggunakan struktur file Laravel standar secara manual (tanpa menjalankan
> `composer create-project` di lingkungan pembuatannya), sehingga folder `vendor/` belum ada.
> Menjalankan `composer install` di komputer Anda akan mengunduh seluruh dependency dari
> `composer.json` (Laravel 11, Sanctum, DomPDF, Maatwebsite Excel, dst) secara normal.

## 4. NPM Install

```bash
npm install
```

## 5. Environment Configuration

```bash
cp .env.example .env
```

Sesuaikan minimal:
- `APP_URL` — URL aplikasi Anda
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — kredensial MySQL Anda
- `MAIL_*` — jika ingin fitur reset password mengirim email sungguhan (default: `log`, email
  hanya dicatat ke `storage/logs/laravel.log`)

**Jangan pernah** commit file `.env` yang berisi kredensial asli ke Git.

## 6. Generate APP_KEY

```bash
php artisan key:generate
```

## 7. Database Configuration

Buat database kosong di MySQL:

```sql
CREATE DATABASE mediscare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Pastikan `DB_DATABASE=mediscare` (atau nama yang Anda pilih) sudah sesuai di `.env`.

## 8. Migration

```bash
php artisan migrate
```

## 9. Seeder

```bash
php artisan db:seed
```

Perintah di atas menjalankan seluruh seeder secara berurutan: role & permission (RBAC),
akun pengguna demo per role, spesialisasi, poliklinik, dokter, ruangan & bed, obat, dan
data demo lintas modul (pasien, jadwal, kunjungan, rekam medis, invoice).

Atau jalankan migration + seeder sekaligus:

```bash
php artisan migrate --seed
```

### Akun Demo (password default: `Password123`)

| Role | Email |
|---|---|
| Super Admin | superadmin@mediscare.local |
| Admin Rumah Sakit | admin@mediscare.local |
| Dokter | dr.andi@mediscare.local |
| Perawat | perawat.sari@mediscare.local |
| Petugas Pendaftaran | pendaftaran@mediscare.local |
| Petugas Administrasi | administrasi@mediscare.local |
| Manajemen | manajemen@mediscare.local |

**Wajib ganti password default ini sebelum digunakan di luar lingkungan development.**

## 10. Run Laravel

```bash
php artisan serve
```

Aplikasi dapat diakses di `http://localhost:8000` (atau URL yang tercetak di terminal).

## 11. Run Vite (development, hot-reload)

Di terminal terpisah:

```bash
npm run dev
```

## 12. Build Production

```bash
npm run build
```

Kemudian jalankan Laravel dengan web server produksi (Nginx/Apache + PHP-FPM), bukan
`php artisan serve` yang hanya untuk pengembangan.

## 13. PWA Installation

Aplikasi sudah dilengkapi `public/manifest.json`, `public/sw.js` (service worker), dan
`public/offline.html`. Setelah dijalankan lewat HTTPS (wajib untuk service worker di
production; `localhost` dikecualikan untuk development):

- **Android/Desktop Chrome**: buka aplikasi di browser → menu "Add to Home Screen" / "Install App"
- **iOS Safari**: buka aplikasi → tombol Share → "Add to Home Screen"

Untuk membungkus menjadi aplikasi native Android/iOS tanpa mengubah backend Laravel:

```bash
npm install -g @capacitor/cli
npx cap init MedisCare com.mediscare.app
npx cap add android
npx cap add ios
```

Arahkan `webDir` di `capacitor.config.json` ke build output Vite/Laravel Anda, lalu jalankan
`npx cap sync` setiap kali ada perubahan frontend.

## 14. Testing

```bash
php artisan test
```

Atau langsung dengan PHPUnit:

```bash
./vendor/bin/phpunit
```

Test suite mencakup: autentikasi (rate limiting, akun nonaktif), otorisasi lintas role,
CRUD pasien/dokter, deteksi bentrok jadwal, alur pendaftaran & antrean, rawat inap (bed
locking), validasi stok obat, pembatasan pembayaran, akses laporan agregat vs rinci,
dan halaman-halaman admin (PWA, manajemen pengguna, poliklinik).

## Struktur Proyek

```
app/
├── Models/            # 28 Eloquent model
├── Http/
│   ├── Controllers/Web/
│   ├── Requests/      # Form Request per modul
│   └── Middleware/    # CheckRole, CheckPermission, EnsureSessionIsFresh
├── Policies/          # Otorisasi backend per model
├── Services/          # NumberGeneratorService, RegistrationService, BillingService, dst
├── Notifications/     # Notifikasi database (Bagian 23)
└── Exports/           # Export Excel (Maatwebsite)

database/
├── migrations/        # 28+ migration
├── seeders/           # RBAC, master data, demo data
└── factories/

resources/
├── views/             # Blade, mobile-first (Tailwind + Alpine.js)
├── css/ js/

routes/
├── web.php
└── api.php
```

## Keamanan

- RBAC lewat Laravel Policies/Gates — otorisasi selalu diperiksa di backend, tidak hanya
  menyembunyikan tombol di frontend
- Rate limiting & lockout pada login, CSRF protection bawaan Laravel, session timeout idle
  30 menit
- Rekam medis tidak pernah dihapus permanen — setiap perubahan dicatat sebagai revisi
  (audit trail)
- Tidak ada kolom data kartu pembayaran sensitif di skema database mana pun
- Hasil radiologi disimpan di disk non-publik, hanya bisa diunduh lewat route terautentikasi
- Audit log mencatat user, role, aksi, modul, record ID, timestamp, IP, dan user agent untuk
  setiap aktivitas sensitif
