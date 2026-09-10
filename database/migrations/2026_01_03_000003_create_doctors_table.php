<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('doctor_code', 20)->unique(); // DOK-000001
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('nip', 30)->nullable()->unique();
            $table->string('str_number', 50)->nullable(); // Nomor STR
            $table->string('sip_number', 50)->nullable(); // Nomor SIP
            $table->foreignId('specialty_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('polyclinic_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->json('working_hours')->nullable(); // ringkasan jam kerja umum
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'specialty_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
