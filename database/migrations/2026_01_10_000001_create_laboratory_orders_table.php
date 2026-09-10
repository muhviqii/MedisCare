<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratory_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique(); // LAB-2026-000001
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('examination_type'); // Jenis pemeriksaan
            $table->dateTime('order_date');
            $table->enum('status', ['requested', 'processing', 'completed'])->default('requested');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('laboratory_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_order_id')->constrained()->cascadeOnDelete();
            $table->string('parameter_name');
            $table->string('result_value', 100);
            $table->string('normal_value', 100)->nullable();
            $table->string('unit', 30)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratory_results');
        Schema::dropIfExists('laboratory_orders');
    }
};
