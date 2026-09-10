<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiology_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique(); // RAD-2026-000001
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('examination_type');
            $table->dateTime('order_date');
            $table->enum('status', ['requested', 'processing', 'completed'])->default('requested');
            $table->timestamps();
        });

        Schema::create('radiology_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('radiology_order_id')->constrained()->cascadeOnDelete();
            $table->text('findings')->nullable(); // Hasil
            $table->text('conclusion')->nullable(); // Kesimpulan
            $table->string('result_file')->nullable(); // path storage aman
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_results');
        Schema::dropIfExists('radiology_orders');
    }
};
