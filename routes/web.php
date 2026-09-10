<?php

use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->middleware('throttle:5,1')->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.store');
});

Route::middleware(['auth', \App\Http\Middleware\EnsureSessionIsFresh::class])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    // Modul Pasien (Tahap 3)
    Route::middleware('permission:patients.view')->group(function () {
        Route::get('/patients', [\App\Http\Controllers\Web\PatientController::class, 'index'])->name('patients.index');
        Route::get('/patients/{patient}', [\App\Http\Controllers\Web\PatientController::class, 'show'])->name('patients.show');
    });
    Route::middleware('permission:patients.manage')->group(function () {
        Route::get('/patients-create', [\App\Http\Controllers\Web\PatientController::class, 'create'])->name('patients.create');
        Route::post('/patients', [\App\Http\Controllers\Web\PatientController::class, 'store'])->name('patients.store');
        Route::get('/patients/{patient}/edit', [\App\Http\Controllers\Web\PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{patient}', [\App\Http\Controllers\Web\PatientController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{patient}', [\App\Http\Controllers\Web\PatientController::class, 'destroy'])->name('patients.destroy');
    });

    // Modul Rekam Medis Elektronik (Tahap 3)
    Route::middleware('permission:medical_records.view')->group(function () {
        Route::get('/medical-records/{medical_record}', [\App\Http\Controllers\Web\MedicalRecordController::class, 'show'])->name('medical-records.show');
    });
    Route::middleware('permission:medical_records.manage')->group(function () {
        Route::get('/medical-records-create', [\App\Http\Controllers\Web\MedicalRecordController::class, 'create'])->name('medical-records.create');
        Route::post('/medical-records', [\App\Http\Controllers\Web\MedicalRecordController::class, 'store'])->name('medical-records.store');
        Route::get('/medical-records/{medical_record}/edit', [\App\Http\Controllers\Web\MedicalRecordController::class, 'edit'])->name('medical-records.edit');
        Route::put('/medical-records/{medical_record}', [\App\Http\Controllers\Web\MedicalRecordController::class, 'update'])->name('medical-records.update');
    });

    // Modul Dokter (Tahap 4)
    Route::get('/doctors', [\App\Http\Controllers\Web\DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [\App\Http\Controllers\Web\DoctorController::class, 'show'])->name('doctors.show');
    Route::middleware('permission:doctors.manage')->group(function () {
        Route::get('/doctors-create', [\App\Http\Controllers\Web\DoctorController::class, 'create'])->name('doctors.create');
        Route::post('/doctors', [\App\Http\Controllers\Web\DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/doctors/{doctor}/edit', [\App\Http\Controllers\Web\DoctorController::class, 'edit'])->name('doctors.edit');
        Route::put('/doctors/{doctor}', [\App\Http\Controllers\Web\DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/doctors/{doctor}', [\App\Http\Controllers\Web\DoctorController::class, 'destroy'])->name('doctors.destroy');
    });

    // Modul Jadwal Dokter (Tahap 4)
    Route::get('/schedules', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'index'])->name('schedules.index');
    Route::middleware('permission:schedules.manage')->group(function () {
        Route::get('/schedules-create', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/schedules', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/schedules/{schedule}/edit', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/{schedule}', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'destroy'])->name('schedules.destroy');
        Route::post('/doctors/{doctor}/leave', [\App\Http\Controllers\Web\DoctorScheduleController::class, 'markLeave'])->name('doctors.leave');
    });

    // Modul Pendaftaran (Tahap 5)
    Route::middleware('permission:registrations.manage')->group(function () {
        Route::get('/registration', [\App\Http\Controllers\Web\RegistrationController::class, 'index'])->name('registration.index');
        Route::get('/registration-create', [\App\Http\Controllers\Web\RegistrationController::class, 'create'])->name('registration.create');
        Route::get('/registration/polyclinics/{polyclinic}/doctors', [\App\Http\Controllers\Web\RegistrationController::class, 'doctorsByPolyclinic'])->name('registration.doctors-by-polyclinic');
        Route::post('/registration', [\App\Http\Controllers\Web\RegistrationController::class, 'store'])->name('registration.store');
        Route::get('/registration/{registration}', [\App\Http\Controllers\Web\RegistrationController::class, 'show'])->name('registration.show');
    });

    // Modul Antrean (Tahap 5)
    Route::middleware('permission:queues.manage')->group(function () {
        Route::get('/queue', [\App\Http\Controllers\Web\QueueController::class, 'index'])->name('queue.index');
        Route::post('/queue/{queue}/call', [\App\Http\Controllers\Web\QueueController::class, 'call'])->name('queue.call');
        Route::post('/queue/{queue}/skip', [\App\Http\Controllers\Web\QueueController::class, 'skip'])->name('queue.skip');
        Route::post('/queue/{queue}/recall', [\App\Http\Controllers\Web\QueueController::class, 'recall'])->name('queue.recall');
        Route::post('/queue/{queue}/complete', [\App\Http\Controllers\Web\QueueController::class, 'complete'])->name('queue.complete');
    });

    // Modul Rawat Jalan (Tahap 6)
    Route::get('/outpatient', [\App\Http\Controllers\Web\OutpatientController::class, 'index'])->name('outpatient.index');
    Route::get('/outpatient/{outpatient}', [\App\Http\Controllers\Web\OutpatientController::class, 'show'])->name('outpatient.show');
    Route::post('/outpatient/{outpatient}/start', [\App\Http\Controllers\Web\OutpatientController::class, 'markInService'])->name('outpatient.start');
    Route::post('/outpatient/{outpatient}/complete', [\App\Http\Controllers\Web\OutpatientController::class, 'complete'])->name('outpatient.complete');

    // Modul Rawat Inap (Tahap 6)
    Route::middleware('permission:admissions.manage')->group(function () {
        Route::get('/inpatient', [\App\Http\Controllers\Web\AdmissionController::class, 'index'])->name('inpatient.index');
        Route::get('/inpatient-create', [\App\Http\Controllers\Web\AdmissionController::class, 'create'])->name('inpatient.create');
        Route::post('/inpatient', [\App\Http\Controllers\Web\AdmissionController::class, 'store'])->name('inpatient.store');
        Route::get('/inpatient/{inpatient}', [\App\Http\Controllers\Web\AdmissionController::class, 'show'])->name('inpatient.show');
        Route::post('/inpatient/{inpatient}/discharge', [\App\Http\Controllers\Web\AdmissionController::class, 'discharge'])->name('inpatient.discharge');
    });

    // Modul Kamar & Bed (Tahap 6)
    Route::get('/rooms', [\App\Http\Controllers\Web\RoomController::class, 'index'])->name('rooms.index');
    Route::middleware('role:super_admin,admin_rs')->group(function () {
        Route::get('/rooms-create', [\App\Http\Controllers\Web\RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [\App\Http\Controllers\Web\RoomController::class, 'store'])->name('rooms.store');
    });
    Route::post('/beds/{bed}/status', [\App\Http\Controllers\Web\RoomController::class, 'updateBedStatus'])->name('beds.update-status');

    // Modul Resep & Obat (Tahap 7)
    Route::middleware('permission:pharmacy.manage')->group(function () {
        Route::get('/medications', [\App\Http\Controllers\Web\MedicationController::class, 'index'])->name('medications.index');
        Route::get('/medications-create', [\App\Http\Controllers\Web\MedicationController::class, 'create'])->name('medications.create');
        Route::post('/medications', [\App\Http\Controllers\Web\MedicationController::class, 'store'])->name('medications.store');
        Route::get('/medications/{medication}/edit', [\App\Http\Controllers\Web\MedicationController::class, 'edit'])->name('medications.edit');
        Route::put('/medications/{medication}', [\App\Http\Controllers\Web\MedicationController::class, 'update'])->name('medications.update');

        Route::get('/prescriptions-create', [\App\Http\Controllers\Web\PrescriptionController::class, 'create'])->name('prescriptions.create');
        Route::post('/prescriptions', [\App\Http\Controllers\Web\PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::post('/prescriptions/{prescription}/dispense', [\App\Http\Controllers\Web\PrescriptionController::class, 'dispense'])->name('prescriptions.dispense');
    });

    // Modul Laboratorium (Tahap 7)
    Route::middleware('permission:laboratory.manage')->group(function () {
        Route::get('/laboratory', [\App\Http\Controllers\Web\LaboratoryController::class, 'index'])->name('laboratory.index');
        Route::get('/laboratory-create', [\App\Http\Controllers\Web\LaboratoryController::class, 'create'])->name('laboratory.create');
        Route::post('/laboratory', [\App\Http\Controllers\Web\LaboratoryController::class, 'store'])->name('laboratory.store');
        Route::get('/laboratory/{laboratory}', [\App\Http\Controllers\Web\LaboratoryController::class, 'show'])->name('laboratory.show');
        Route::post('/laboratory/{laboratory}/process', [\App\Http\Controllers\Web\LaboratoryController::class, 'process'])->name('laboratory.process');
        Route::post('/laboratory/{laboratory}/results', [\App\Http\Controllers\Web\LaboratoryController::class, 'storeResults'])->name('laboratory.results.store');
    });

    // Modul Radiologi (Tahap 7)
    Route::middleware('permission:radiology.manage')->group(function () {
        Route::get('/radiology', [\App\Http\Controllers\Web\RadiologyController::class, 'index'])->name('radiology.index');
        Route::get('/radiology-create', [\App\Http\Controllers\Web\RadiologyController::class, 'create'])->name('radiology.create');
        Route::post('/radiology', [\App\Http\Controllers\Web\RadiologyController::class, 'store'])->name('radiology.store');
        Route::get('/radiology/{radiology}', [\App\Http\Controllers\Web\RadiologyController::class, 'show'])->name('radiology.show');
        Route::post('/radiology/{radiology}/result', [\App\Http\Controllers\Web\RadiologyController::class, 'storeResult'])->name('radiology.result.store');
        Route::get('/radiology/{radiology}/download', [\App\Http\Controllers\Web\RadiologyController::class, 'downloadResult'])->name('radiology.download');
    });

    // Modul Administrasi, Invoice & Pembayaran (Tahap 8)
    Route::middleware('permission:billing.manage')->group(function () {
        Route::get('/invoices', [\App\Http\Controllers\Web\InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{invoice}', [\App\Http\Controllers\Web\InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('/appointments/{appointment}/generate-invoice', [\App\Http\Controllers\Web\InvoiceController::class, 'generateFromAppointment'])->name('invoices.generate-from-appointment');
        Route::post('/admissions/{admission}/generate-invoice', [\App\Http\Controllers\Web\InvoiceController::class, 'generateFromAdmission'])->name('invoices.generate-from-admission');
        Route::post('/invoices/{invoice}/payments', [\App\Http\Controllers\Web\PaymentController::class, 'store'])->name('payments.store');
    });

    // Modul Laporan (Tahap 9)
    Route::get('/reports', [\App\Http\Controllers\Web\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/patients', [\App\Http\Controllers\Web\ReportController::class, 'patients'])->name('reports.patients');
    Route::get('/reports/visits', [\App\Http\Controllers\Web\ReportController::class, 'visits'])->name('reports.visits');
    Route::get('/reports/revenue', [\App\Http\Controllers\Web\ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/bed-usage', [\App\Http\Controllers\Web\ReportController::class, 'bedUsage'])->name('reports.bed-usage');
    Route::get('/reports/export/patients', [\App\Http\Controllers\Web\ReportController::class, 'exportPatients'])->name('reports.export.patients');
    Route::get('/reports/export/invoices', [\App\Http\Controllers\Web\ReportController::class, 'exportInvoices'])->name('reports.export.invoices');
    Route::get('/reports/export/revenue-pdf', [\App\Http\Controllers\Web\ReportController::class, 'exportRevenuePdf'])->name('reports.export.revenue-pdf');

    // Modul Notifikasi (Tahap 9)
    Route::get('/notifications', [\App\Http\Controllers\Web\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Web\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\Web\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Modul Audit Log (Tahap 9)
    Route::get('/audit-logs', [\App\Http\Controllers\Web\AuditLogController::class, 'index'])->name('audit-logs.index');

    // Modul Poli / Master Data (Tahap 10)
    Route::get('/polyclinics', [\App\Http\Controllers\Web\PolyclinicController::class, 'index'])->name('polyclinics.index');
    Route::middleware('role:super_admin,admin_rs')->group(function () {
        Route::get('/polyclinics-create', [\App\Http\Controllers\Web\PolyclinicController::class, 'create'])->name('polyclinics.create');
        Route::post('/polyclinics', [\App\Http\Controllers\Web\PolyclinicController::class, 'store'])->name('polyclinics.store');
        Route::post('/polyclinics/{polyclinic}/toggle', [\App\Http\Controllers\Web\PolyclinicController::class, 'toggleActive'])->name('polyclinics.toggle');
    });

    // Daftar Resep (Tahap 10)
    Route::middleware('permission:pharmacy.manage')->group(function () {
        Route::get('/prescriptions', [\App\Http\Controllers\Web\PrescriptionListController::class, 'index'])->name('prescriptions.index');
    });

    // Modul Manajemen Pengguna (Tahap 10)
    Route::middleware('permission:users.manage')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Web\UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users-create', [\App\Http\Controllers\Web\UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Web\UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Web\UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Web\UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Web\UserManagementController::class, 'destroy'])->name('users.destroy');
    });

    // Settings (Tahap 10)
    Route::middleware('role:super_admin,admin_rs')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\Web\SettingsController::class, 'index'])->name('settings.index');
    });
});

Route::get('/', function () {
    $next = auth()->check() ? route('dashboard') : route('login');

    return view('splash', ['next' => $next]);
});
