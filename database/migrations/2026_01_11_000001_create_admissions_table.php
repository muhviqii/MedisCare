<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_code', 20)->unique(); // ADM-2026-000001
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained()->restrictOnDelete();
            $table->dateTime('admission_date'); // Tanggal masuk
            $table->dateTime('discharge_date')->nullable(); // Tanggal keluar
            $table->text('diagnosis')->nullable();
            $table->enum('status', ['admitted', 'active', 'discharged', 'cancelled'])->default('admitted');
            $table->text('discharge_notes')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['patient_id', 'admission_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
