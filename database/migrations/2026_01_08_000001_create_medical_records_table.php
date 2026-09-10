<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_code', 20)->unique(); // EMR-2026-000001
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nurse_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('examination_date');
            $table->text('chief_complaint')->nullable(); // Keluhan utama
            $table->text('medical_history')->nullable(); // Riwayat penyakit
            $table->text('physical_examination')->nullable();
            $table->string('blood_pressure', 20)->nullable(); // 120/80
            $table->unsignedSmallInteger('pulse_rate')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->unsignedSmallInteger('respiratory_rate')->nullable();
            $table->unsignedTinyInteger('oxygen_saturation')->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->decimal('height_cm', 5, 2)->nullable();
            $table->text('diagnosis_notes')->nullable();
            $table->text('doctor_notes')->nullable();
            $table->text('nurse_notes')->nullable();
            $table->text('treatment_plan')->nullable(); // Rencana terapi
            $table->date('follow_up_date')->nullable();
            $table->timestamps();

            $table->index(['patient_id', 'examination_date']);
            $table->index(['doctor_id']);
        });

        // Audit trail rekam medis: setiap perubahan dicatat, tidak pernah dihapus permanen
        Schema::create('medical_record_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('previous_data');
            $table->json('new_data');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_record_revisions');
        Schema::dropIfExists('medical_records');
    }
};
