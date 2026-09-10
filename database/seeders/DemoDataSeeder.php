<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Invoice;
use App\Models\LaboratoryOrder;
use App\Models\MedicalAction;
use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Prescription;
use App\Models\Queue;
use App\Models\RadiologyOrder;
use App\Services\NumberGeneratorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Data demo lintas modul (Bagian 34): 10-50 pasien, 20 jadwal dokter, 20 appointment,
 * 20 medical records, 10 invoice — seluruhnya data FIKTIF untuk keperluan demo/testing.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $numberGenerator = app(NumberGeneratorService::class);
        $doctors = Doctor::all();
        $polyclinics = Polyclinic::all();
        $medications = Medication::all();

        if ($doctors->isEmpty() || $polyclinics->isEmpty()) {
            $this->command?->warn('Jalankan DoctorSeeder & PolyclinicSeeder terlebih dahulu.');

            return;
        }

        // 30 pasien dummy
        $patients = Patient::factory()->count(30)->create();

        // 20 jadwal dokter (hari ini s.d. 10 hari ke depan)
        foreach (range(1, 20) as $i) {
            DoctorSchedule::factory()->create([
                'doctor_id' => $doctors->random()->id,
                'polyclinic_id' => $polyclinics->random()->id,
                'schedule_date' => now()->addDays(random_int(0, 10))->toDateString(),
            ]);
        }

        // 20 appointment + antrean + rekam medis lengkap dengan diagnosis/tindakan/resep/lab/radiologi
        foreach (range(1, 20) as $i) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            $polyclinic = $polyclinics->random();
            $date = now()->subDays(random_int(0, 14));

            $appointment = Appointment::create([
                'appointment_code' => $numberGenerator->generate('appointments', 'appointment_code', 'APT'),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'polyclinic_id' => $polyclinic->id,
                'appointment_date' => $date->toDateString(),
                'patient_type' => $i % 3 === 0 ? 'new' : 'returning',
                'status' => 'completed',
            ]);

            Queue::create([
                'appointment_id' => $appointment->id,
                'polyclinic_id' => $polyclinic->id,
                'queue_number' => 'A-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'queue_date' => $date->toDateString(),
                'status' => 'completed',
                'called_at' => $date,
                'completed_at' => $date->copy()->addMinutes(15),
            ]);

            $record = MedicalRecord::create([
                'record_code' => $numberGenerator->generate('medical_records', 'record_code', 'EMR'),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_id' => $appointment->id,
                'examination_date' => $date,
                'chief_complaint' => collect(['Demam', 'Batuk pilek', 'Sakit kepala', 'Nyeri perut', 'Pemeriksaan rutin'])->random(),
                'blood_pressure' => random_int(100, 140).'/'.random_int(70, 90),
                'pulse_rate' => random_int(60, 100),
                'temperature' => round(random_int(360, 380) / 10, 1),
                'weight_kg' => random_int(40, 90),
                'height_cm' => random_int(150, 180),
            ]);

            Diagnosis::create([
                'medical_record_id' => $record->id,
                'diagnosis_name' => collect(['ISPA', 'Gastritis', 'Hipertensi ringan', 'Migrain', 'Sehat'])->random(),
                'diagnosis_type' => 'primary',
            ]);

            MedicalAction::create([
                'medical_record_id' => $record->id,
                'action_name' => 'Konsultasi Dokter',
                'cost' => 100000,
                'performed_at' => $date,
            ]);

            if ($medications->isNotEmpty() && $i % 2 === 0) {
                $prescription = Prescription::create([
                    'prescription_code' => $numberGenerator->generate('prescriptions', 'prescription_code', 'RSP'),
                    'medical_record_id' => $record->id,
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'status' => 'dispensed',
                ]);

                $medication = $medications->random();
                $prescription->items()->create([
                    'medication_id' => $medication->id,
                    'dosage' => $medication->dosage ?? '1 tablet',
                    'frequency' => '3x1',
                    'duration' => '5 hari',
                    'quantity' => 15,
                ]);
            }

            if ($i % 4 === 0) {
                LaboratoryOrder::create([
                    'order_code' => $numberGenerator->generate('laboratory_orders', 'order_code', 'LAB'),
                    'medical_record_id' => $record->id,
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'examination_type' => 'Darah Lengkap',
                    'order_date' => $date,
                    'status' => 'completed',
                ]);
            }

            if ($i % 5 === 0) {
                RadiologyOrder::create([
                    'order_code' => $numberGenerator->generate('radiology_orders', 'order_code', 'RAD'),
                    'medical_record_id' => $record->id,
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'examination_type' => 'Rontgen Thorax',
                    'order_date' => $date,
                    'status' => 'completed',
                ]);
            }
        }

        // 10 invoice dummy (campuran status)
        $statuses = ['unpaid', 'partial', 'paid'];
        foreach (range(1, 10) as $i) {
            $patient = $patients->random();
            $subtotal = random_int(100000, 1500000);
            $paid = $statuses[$i % 3] === 'paid' ? $subtotal : ($statuses[$i % 3] === 'partial' ? intdiv($subtotal, 2) : 0);

            Invoice::create([
                'invoice_number' => $numberGenerator->generate('invoices', 'invoice_number', 'INV'),
                'patient_id' => $patient->id,
                'service_type' => 'outpatient',
                'subtotal' => $subtotal,
                'grand_total' => $subtotal,
                'paid_amount' => $paid,
                'status' => $statuses[$i % 3],
            ]);
        }
    }
}
