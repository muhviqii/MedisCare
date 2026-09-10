<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('polyclinic_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('day_of_week', ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'])->nullable();
            $table->date('schedule_date'); // tanggal spesifik (untuk jadwal harian & cuti)
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room', 50)->nullable();
            $table->enum('status', ['available', 'on_leave', 'holiday', 'cancelled'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['doctor_id', 'schedule_date']);
            $table->index(['schedule_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
