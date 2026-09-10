<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('building'); // Gedung
            $table->string('floor', 20); // Lantai
            $table->string('room_number', 20); // Nomor ruangan
            $table->enum('room_class', ['vip', 'class_1', 'class_2', 'class_3', 'icu', 'isolation'])->default('class_3');
            $table->decimal('daily_rate', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['building', 'floor', 'room_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
