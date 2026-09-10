<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('polyclinic_id')->constrained()->cascadeOnDelete();
            $table->string('queue_number', 10); // A-001
            $table->date('queue_date');
            $table->enum('status', ['waiting', 'called', 'skipped', 'in_service', 'completed'])->default('waiting');
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['polyclinic_id', 'queue_date', 'queue_number']);
            $table->index(['queue_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
