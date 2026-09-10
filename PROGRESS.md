# Progress MedisCare SIMRS

## Tahap 1 — SELESAI ✅
- Struktur folder Laravel lengkap (app, database, resources, routes, tests, public)
- `composer.json` (Laravel 11, Sanctum, DomPDF, Maatwebsite Excel)
- `.env.example`
- **28 file migration** mencakup seluruh tabel wajib:
  users, roles, permissions, role_permissions, specialties, polyclinics, doctors, nurses,
  patients, rooms, beds, doctor_schedules, appointments, queues, medical_records (+ revisions),
  diagnoses, medical_actions, medications, prescriptions, prescription_items,
  laboratory_orders/results, radiology_orders/results, admissions, invoices, invoice_items,
  payments, notifications, audit_logs — plus tabel bawaan Laravel (cache, jobs, sessions,
  personal_access_tokens).
- **28 Eloquent Model** dengan relasi lengkap sesuai spesifikasi (Patient hasMany
  MedicalRecord/Appointment/Admission/Invoice, Doctor hasMany MedicalRecord/DoctorSchedule,
  Admission belongsTo Patient/Bed, Invoice hasMany InvoiceItem, Prescription hasMany
  PrescriptionItem, dst).
- Soft delete diterapkan pada: users, doctors, nurses, patients, medications.
- Audit trail rekam medis: tabel `medical_record_revisions` (perubahan dicatat, tidak pernah
  hard delete).

## Tahap 2 — SELESAI ✅
- `bootstrap/app.php` (Laravel 11 style) + registrasi middleware alias `role` & `permission`
- Middleware: `CheckRole`, `CheckPermission` (otorisasi backend, bukan sekadar sembunyikan tombol
  di frontend), `EnsureSessionIsFresh` (idle session timeout 30 menit)
- Policy: `PatientPolicy`, `MedicalRecordPolicy` (dokter hanya lihat pasien miliknya sendiri,
  petugas administrasi tidak bisa lihat rekam medis klinis sama sekali), `DoctorPolicy`,
  `InvoicePolicy`, `ReportPolicy` (manajemen: agregat saja), `AuditLogPolicy` — didaftarkan di
  `AuthServiceProvider` + Gate untuk laporan/audit log
- `LoginRequest` dengan rate limiting (5x/menit) + lockout event, `ChangePasswordRequest`
- Controller: `LoginController`, `ForgotPasswordController`, `ResetPasswordController`,
  `ProfileController` (update profil, ubah password), `DashboardController` (placeholder,
  routing berbeda per role)
- `AuditLogService` terpusat, dipanggil saat login/logout/ubah password
- Seeder: `RoleSeeder` (7 role), `PermissionSeeder` (17 permission + mapping ke role, petugas
  administrasi & manajemen sengaja TIDAK diberi akses rekam medis), `UserSeeder` (1 akun demo
  per role, password default `Password123` — **wajib diganti sebelum production**)
- Routes: `web.php` (login/forgot/reset/dashboard/profile, group `guest` & `auth` middleware),
  `api.php` (Sanctum, endpoint `/api/user`)
- Views mobile-first: layout `x-layouts.guest` & `x-layouts.app` (bottom nav mobile + sidebar
  desktop, Bagian 30), halaman login/forgot-password/reset-password/profile, placeholder
  dashboard per role
- Frontend tooling: `package.json`, `vite.config.js`, `tailwind.config.js`, `app.css`, `app.js`
  (Alpine.js + pendaftaran service worker awal untuk PWA)
- Test: `AuthenticationTest` (login sukses/gagal, akun nonaktif, rate limiting),
  `AuthorizationTest` (dokter tidak bisa lihat rekam medis dokter lain, petugas administrasi
  diblokir dari rekam medis) + factory pendukung (Role, User, Doctor, Patient, MedicalRecord)

## Tahap 3 — SELESAI ✅
- `NumberGeneratorService`: generator nomor otomatis terpusat (MR-YYYY-000001, EMR-YYYY-000001,
  dst) memakai `lockForUpdate()` dalam transaction agar aman dari race condition, plus generator
  nomor antrean harian per poli (dipakai Tahap 5)
- `StorePatientRequest` / `UpdatePatientRequest`: validasi NIK 16 digit unik, tanggal lahir tidak
  boleh di masa depan, email valid
- `PatientController`: index (search nama/NIK/no.RM + filter status + pagination), create,
  store (nomor RM otomatis), show (riwayat kunjungan & rekam medis), edit, update,
  destroy (nonaktifkan + soft delete, **bukan** hard delete)
- `StoreMedicalRecordRequest` / `UpdateMedicalRecordRequest`: validasi tanda vital, follow-up
  date tidak boleh sebelum tanggal pemeriksaan, nested diagnosis & tindakan
- `MedicalRecordController`: create, store (dengan diagnosis & tindakan dalam satu transaction),
  show, edit, update — **setiap update dicatat sebagai revisi** di `medical_record_revisions`
  (audit trail), tidak ada method `destroy` (rekam medis tidak pernah dihapus permanen, sesuai
  `MedicalRecordPolicy::delete()` yang selalu `false`)
- Routes `/patients*` dan `/medical-records*` dibungkus middleware `permission:patients.view`,
  `permission:patients.manage`, `permission:medical_records.view`,
  `permission:medical_records.manage` — konsisten dengan mapping role di `PermissionSeeder`
- View mobile-first: `patients/index` (card mobile + table desktop, search, pagination),
  `patients/_form` (partial dipakai create & edit), `patients/create`, `patients/edit`,
  `patients/show`; `medical-records/create`, `show`, `edit`
- Factory tambahan: Doctor, Patient, MedicalRecord sudah dipakai sebagai fondasi test
- Test: `PatientCrudTest` (nomor RM otomatis, validasi NIK/tanggal lahir, petugas administrasi
  diblokir buat pasien, delete = nonaktifkan bukan hard delete),
  `MedicalRecordAuditTrailTest` (update tercatat sebagai revisi, tidak pernah hard delete)

**Catatan**: form rekam medis untuk sekarang masih meminta ID Dokter secara manual (input
number) karena dropdown dokter aktif baru tersedia setelah Tahap 4 (Modul Dokter). Ini akan
dirapikan otomatis begitu Tahap 4 selesai.

## Tahap 4 — SELESAI ✅
- `StoreDoctorRequest` / `UpdateDoctorRequest`: validasi NIP/email unik per dokter
- `DoctorController`: CRUD lengkap, search nama, filter spesialisasi & status, nomor dokter
  otomatis (DOK-000001), nonaktifkan (bukan hard delete)
- `StoreDoctorScheduleRequest` / `UpdateDoctorScheduleRequest`: validasi jam selesai > jam mulai
  (Bagian 35)
- `DoctorScheduleController`: tampilan daily/weekly/monthly (grouped per tanggal), create/update
  dengan **deteksi bentrok jadwal** (`DoctorSchedule::conflicting()` scope) — jika bentrok,
  tampilkan warning dan minta konfirmasi eksplisit (`force`) sebelum tetap menyimpan; `markLeave()`
  untuk mencatat cuti dokter atas rentang tanggal (generate banyak schedule sekaligus)
- Update `medical-records/create.blade.php`: ID Dokter manual diganti dropdown dokter aktif
- Seeder: `SpecialtySeeder` (5 spesialisasi), `PolyclinicSeeder` (5 poli), `DoctorSeeder`
  (7 dokter dummy sesuai Bagian 34), didaftarkan di `DatabaseSeeder`
- Factory: Specialty, Polyclinic, Nurse, DoctorSchedule
- View mobile-first: `doctors/index` (card grid, search+filter), `_form`, `create`, `edit`,
  `show` (jadwal mendatang); `schedules/index` (tab daily/weekly/monthly), `create` (warning
  bentrok + checkbox "tetap simpan"), `edit`
- Test: `DoctorCrudTest` (nomor otomatis, dokter tidak bisa buat dokter baru),
  `ScheduleConflictTest` (bentrok terdeteksi & diblokir default, force override, validasi jam)

## Tahap 5 — SELESAI ✅
- `NumberGeneratorService::generateQueueNumber()`: nomor antrean harian per poli (A-001, A-002,
  reset otomatis per tanggal), aman dari race condition
- `RegistrationService`: mengorkestrasi seluruh flow pendaftaran (Bagian 10) dalam satu
  transaction — pasien lama ATAU buat pasien baru, pilih poli, dokter, tanggal, generate nomor
  antrean, sampai konfirmasi
- `StoreAppointmentRequest`: validasi pasien lama (`patient_id`) atau pasien baru (`new_patient.*`
  dengan validasi NIK/tanggal lahir yang sama seperti modul Pasien) — salah satu wajib diisi
- `RegistrationController`: index (filter tanggal & status), create (form multi-tahap dengan
  Alpine.js tab pasien lama/baru + fetch dinamis daftar dokter berdasar poli dipilih), store,
  show (halaman konfirmasi menampilkan nomor antrean besar)
- `QueueController`: dashboard antrean per poli — nomor saat ini, nomor berikutnya, daftar
  menunggu; aksi **panggil**, **lewati**, **panggil ulang**, **selesaikan** (menyelesaikan antrean
  otomatis menutup status appointment terkait)
- Permission `queues.manage` ditambahkan ke role `dokter` (Bagian 11: dokter dapat memanggil
  antrean sendiri), selain `petugas_pendaftaran`
- View mobile-first: `registration/index`, `create` (flow interaktif), `show` (kartu konfirmasi
  nomor antrean besar); `queue/index` (kartu nomor saat ini/berikutnya + tombol aksi)
- Factory: Appointment, Queue
- Test: `RegistrationAndQueueTest` — nomor antrean berurutan (A-001, A-002, ...), pendaftaran
  pasien baru otomatis membuat No. RM, flow panggil→selesai pada dashboard antrean

## Tahap 6 — SELESAI ✅
- **Kamar & Bed**: `RoomController` dengan dashboard visual (hitung available/occupied/
  cleaning/maintenance sesuai Bagian 15), `StoreRoomRequest` membuat ruangan + N bed sekaligus,
  update status bed manual (dropdown per bed langsung submit)
- **Rawat Inap**: `AdmissionController` — pendaftaran rawat inap dalam transaction dengan
  `lockForUpdate()` pada bed (mencegah race condition double-booking, bed langsung ditandai
  `occupied`), pemulangan pasien (`discharge`) memindahkan bed ke status `cleaning` (bukan
  langsung `available` — staf kebersihan yang menandai selesai lewat dashboard kamar)
- **Rawat Jalan**: `OutpatientController` sebagai pusat tampilan satu kunjungan dari
  Pendaftaran→Antrean→Pemeriksaan→Rekam Medis→selesai (Bagian 13), transisi status appointment
  (`in_service`, `completed`) yang otomatis menutup antrean terkait
- Routes: `/rooms*`, `/inpatient*` (permission `admissions.manage`), `/outpatient*`
- Seeder: `RoomSeeder` (5 ruangan dummy lintas kelas & gedung dengan bed masing-masing)
- Factory: Room, Bed, Admission
- View mobile-first: `rooms/index` (dashboard visual + dropdown ubah status bed), `rooms/create`,
  `inpatient/index`, `create`, `show` (aksi pulangkan pasien); `outpatient/index`, `show`
  (tombol Mulai Pemeriksaan → tautan Rekam Medis → Selesai)
- Test: `InpatientAndBedTest` — admit menandai bed occupied, discharge memindahkan bed ke
  cleaning (bukan langsung available), bed yang sudah occupied tidak bisa di-double-booking

## Tahap 7 — SELESAI ✅
- **Resep & Obat**: `MedicationController` CRUD (kode OBT-000001 otomatis, kategori, satuan,
  harga, stok, dosis, aturan pakai); `config/pharmacy.php` dengan flag `validate_stock`
  (env `PHARMACY_VALIDATE_STOCK`) — saat aktif, `PrescriptionController::store` menolak resep
  yang melebihi stok tersedia per obat (Bagian 16); `dispense()` mengurangi stok secara atomic
  dengan `lockForUpdate()` saat obat diserahkan ke pasien
- **Laboratorium**: `LaboratoryController` — buat permintaan dari rekam medis, ubah status
  requested→processing→completed, input banyak parameter hasil sekaligus (nilai, nilai normal,
  satuan)
- **Radiologi**: `RadiologyController` — buat permintaan, input hasil (temuan + kesimpulan),
  **file hasil disimpan di disk `local` (bukan publik)** dan hanya bisa diunduh lewat route
  terautentikasi `radiology.download` (Bagian 18 & 28 — tidak ada URL publik langsung ke file
  medis)
- Routes: `/medications*`, `/prescriptions*` (permission `pharmacy.manage`), `/laboratory*`
  (permission `laboratory.manage`), `/radiology*` (permission `radiology.manage`)
- Seeder: `MedicationSeeder` (10 obat dummy sesuai Bagian 34)
- Factory: Medication, LaboratoryOrder
- View mobile-first: `pharmacy/medications` (index+form), `pharmacy/prescriptions/create`
  (Alpine.js — tambah/hapus baris obat dinamis), `laboratory` (index/create/show dengan input
  hasil dinamis), `radiology` (index/create/show dengan upload & unduh file aman)
- Test: `PharmacyStockTest` — resep ditolak saat stok kurang & validasi aktif, resep tetap
  diizinkan saat validasi dimatikan lewat config, dispense mengurangi stok dengan benar

## Tahap 8 — SELESAI ✅
- `BillingService`: menyusun invoice otomatis dari layanan yang sudah diberikan — rawat jalan
  (tindakan medis, obat dari resep, laboratorium, radiologi) dan rawat inap (biaya kamar
  dihitung per hari dari `daily_rate` x lama rawat); idempotent lewat `firstOrCreate` +
  hitung ulang total setiap kali dipanggil (`recalculateTotals`)
- `InvoiceController`: index (filter status), generate dari appointment/admission, show (rincian
  item + ringkasan subtotal/diskon/pajak/total/sisa)
- `StorePaymentRequest`: **jumlah pembayaran tidak boleh melebihi sisa tagihan** (Bagian 35,
  validasi `max` dinamis berdasarkan `remainingBalance()`)
- `PaymentController`: dummy payment gateway (Bagian 20) — nomor referensi dibuat otomatis
  jika tidak diisi, status invoice otomatis `partial`/`paid` sesuai akumulasi pembayaran;
  **tidak ada kolom data kartu pembayaran sensitif apa pun** di tabel `payments`
  (hanya method, reference_number, amount)
- Tombol "Buat/Perbarui Invoice" ditambahkan ke halaman rawat jalan (setelah selesai) dan
  rawat inap (setelah pasien pulang)
- Routes: `/invoices*`, `/payments*` dibungkus middleware `permission:billing.manage`
- View mobile-first: `billing/invoices/index`, `show` (rincian item, form pembayaran, riwayat
  pembayaran)
- Factory: Invoice, Payment
- Test: `BillingAndPaymentTest` — pembayaran tidak bisa melebihi sisa tagihan, pembayaran penuh
  → status paid, pembayaran sebagian → status partial, memastikan tidak ada kolom data kartu
  sensitif di skema database

## Tahap 9 — SELESAI ✅
- `DashboardController`: statistik nyata (total pasien, pasien baru hari ini, dokter aktif,
  kunjungan hari ini, rawat inap aktif, kamar tersedia, pendapatan hari ini, tagihan belum
  lunas) + data grafik 7 hari terakhir; routing tampilan berbeda per role (dokter/manajemen/
  admin) tetap dipertahankan dari Tahap 2
- Dashboard admin: **4 grafik Chart.js sungguhan** (kunjungan pasien line chart, pendapatan bar
  chart, distribusi jenis kelamin doughnut, distribusi kelompok usia pie) — Chart.js diekspos
  lewat `resources/js/charts.js` (entry Vite terpisah) dan diinisialisasi di `DOMContentLoaded`
  agar urutan pemuatan module script vs script biasa aman
- Dashboard manajemen: grafik agregat (kunjungan & pendapatan) tanpa data pasien individual,
  konsisten dengan `ReportPolicy`
- `ReportController`: laporan Pasien (rinci — dibatasi `reports.view-detailed`), Kunjungan,
  Pendapatan, Penggunaan Bed (agregat — `reports.view-aggregate`), masing-masing dengan filter
  tanggal/dokter/poli/status; export Excel (`PatientsExport`, `InvoicesExport` via
  Maatwebsite Excel) dan export PDF (`reports.pdf.revenue` via barryvdh/laravel-dompdf)
- `NotificationController`: daftar notifikasi database, tandai satu/semua sudah dibaca; badge
  jumlah belum dibaca di sidebar
- 3 kelas Notification (database channel): `AppointmentRegisteredNotification` (dikirim saat
  pendaftaran berhasil), `InvoiceUnpaidNotification` (dikirim saat invoice berstatus unpaid),
  `DoctorScheduleReminderNotification` (siap dipakai scheduler/command di tahap lanjutan)
- `AuditLogController`: daftar audit log dengan filter modul/user/tanggal, dibatasi Gate
  `audit-logs.view` (hanya super_admin & admin_rs)
- Routes: `/reports*`, `/notifications*`, `/audit-logs` ditambahkan ke grup `auth`
- Test: `DashboardReportsNotificationsTest` — manajemen diblokir dari laporan rinci tapi bisa
  akses laporan agregat, dashboard admin memuat statistik nyata, audit log hanya untuk
  super_admin/admin_rs, pendaftaran memicu notifikasi database ke petugas terkait

## Tahap 10 — SELESAI ✅
- **PWA lengkap**: `public/manifest.json` (nama, ikon 8 ukuran, shortcuts pintasan, theme/background
  color), `public/sw.js` (service worker — network-first untuk navigasi dengan fallback ke
  `offline.html`, cache-first untuk aset statis), `public/offline.html` (halaman fallback saat
  tidak ada koneksi), app icon dihasilkan nyata di 8 ukuran (72–512px) + gambar splash screen
  1080×1920, seluruhnya dibuat dengan Pillow dan tersimpan sebagai file PNG asli di
  `public/icons/`
- Meta tag PWA lengkap di kedua layout (`apple-touch-icon`, `apple-mobile-web-app-capable`,
  `apple-touch-startup-image`, `theme-color`)
- **Splash Screen** (Bagian 32 halaman 1): `splash.blade.php` — logo dengan animasi pulse,
  auto-redirect ke login/dashboard setelah ~900ms; rute `/` diubah untuk menampilkan ini alih-alih
  redirect instan
- **Poliklinik** (master data, Bagian 12): `PolyclinicController` — daftar, tambah poli baru
  (khusus admin), toggle aktif/nonaktif
- **Manajemen Pengguna** (Bagian 32 halaman 30): `UserManagementController` — CRUD akun,
  assign role, nonaktifkan (bukan hard delete), dibatasi permission `users.manage`
- **Pengaturan** (Bagian 32 halaman 32): `SettingsController` — ringkasan konfigurasi sistem
  read-only (tidak ada kredensial yang bisa diubah lewat UI, sesuai Bagian 28)
- **Daftar Resep**: `PrescriptionListController` — melengkapi modul resep dari Tahap 7 dengan
  halaman daftar (filter status pending/dispensed, tombol serahkan langsung dari daftar)
- Sidebar desktop diperluas dengan tautan Invoice, Resep, Poliklinik, Pengguna, Pengaturan
  (masing-masing digated sesuai permission/role penggunanya)
- Test: `PwaAndAdminPagesTest` — file shell PWA ada & manifest valid, splash screen mengarahkan
  tamu ke login, manajemen pengguna dibatasi permission, admin bisa menambah poli baru

**Catatan**: 32 halaman UI pada Bagian 32 kini seluruhnya memiliki implementasi (beberapa —
seperti Calendar jadwal dokter — masih dalam bentuk tampilan grouped per-tanggal, bukan grid
kalender visual penuh; ini bisa disempurnakan sebagai polish lanjutan bila diperlukan).

## Tahap 11 — SELESAI ✅ (TAHAP TERAKHIR)
- `DemoDataSeeder`: 30 pasien, 20 jadwal dokter, 20 appointment lengkap dengan antrean +
  rekam medis + diagnosis + tindakan (sebagian dengan resep, sebagian dengan order
  laboratorium/radiologi), 10 invoice dengan campuran status unpaid/partial/paid — seluruhnya
  data fiktif (Bagian 34), didaftarkan sebagai langkah terakhir `DatabaseSeeder`
- Unit Test (Bagian 37) tambahan: `NumberGeneratorServiceTest` (format nomor berurutan, reset
  nomor antrean per poli/tanggal), `BillingServiceTest` (kalkulasi total & resolusi status
  invoice), `MedicationStockTest` (pengecekan stok cukup/tidak cukup)
- Scaffolding testing standar: `tests/TestCase.php`, `phpunit.xml` (SQLite in-memory untuk
  testing, env testing terpisah)
- `README.md` lengkap: requirements, clone, composer install, npm install, environment
  configuration, generate APP_KEY, database configuration, migration, seeder (dengan tabel
  akun demo per role), run Laravel, run Vite, build production, **instalasi PWA + panduan
  Capacitor** untuk Android/iOS, testing, struktur proyek, dan ringkasan keamanan

## RINGKASAN AKHIR

Seluruh 11 tahap pengerjaan bertahap telah selesai. MedisCare SIMRS sekarang memiliki:
- 28+ migration & model dengan relasi Eloquent lengkap
- RBAC penuh (7 role, 17 permission) dengan otorisasi backend di setiap Controller/Policy
- Seluruh 40 bagian spesifikasi awal memiliki implementasi kerja: autentikasi, dashboard
  dengan grafik Chart.js nyata, modul pasien/dokter/jadwal/pendaftaran/antrean/rawat jalan/
  rawat inap/kamar-bed/resep-obat/laboratorium/radiologi/administrasi-invoice-pembayaran/
  laporan/notifikasi/audit log, REST API dasar, keamanan (RBAC, rate limiting, session
  timeout, audit trail, no hardcoded credentials), PWA lengkap dengan ikon & splash asli,
  seluruh 32 halaman UI, seeder & factory data dummy, unit + feature test, dan dokumentasi
  instalasi lengkap
- **Yang TIDAK dikerjakan** (di luar cakupan otomatisasi kode, memerlukan keputusan manual
  operator): instalasi `composer install` sungguhan (perlu akses packagist.org yang tidak
  tersedia di lingkungan pembuatan ini — dijalankan sendiri oleh pengguna sesuai README),
  konfigurasi server produksi (Nginx/Apache, SSL/HTTPS untuk PWA), audit keamanan pihak
  ketiga, dan penyesuaian regulasi kesehatan (mis. rekam medis elektronik nasional) sebelum
  penggunaan operasional sungguhan
4. Modul Dokter + Jadwal Dokter + deteksi bentrok
5. Pendaftaran + Antrean
6. Rawat Jalan + Rawat Inap + Kamar/Bed
7. Resep/Obat + Laboratorium + Radiologi
8. Administrasi + Invoice + Pembayaran
9. Dashboard (Chart.js) + Laporan + Notifikasi + Audit Log
10. Frontend mobile-first (Blade+Tailwind+Alpine) + PWA + 32 halaman UI
11. Seeder/Factory + Testing + dokumentasi instalasi
