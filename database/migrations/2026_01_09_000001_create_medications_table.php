<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique(); // OBT-000001
            $table->string('name');
            $table->string('category', 100)->nullable();
            $table->string('unit', 30); // tablet, botol, strip, dll
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->string('dosage', 100)->nullable(); // dosis standar
            $table->text('usage_instructions')->nullable(); // aturan penggunaan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
