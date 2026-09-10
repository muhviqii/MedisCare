<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->string('icd10_code', 20)->nullable();
            $table->string('diagnosis_name');
            $table->enum('diagnosis_type', ['primary', 'secondary'])->default('primary');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('icd10_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
