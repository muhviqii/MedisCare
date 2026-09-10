<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code', 20)->unique(); // PAY-2026-000001
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            // Tidak menyimpan data kartu pembayaran sensitif - hanya metode & referensi dummy gateway
            $table->enum('method', ['cash', 'transfer', 'debit', 'qris', 'insurance']);
            $table->string('reference_number', 100)->nullable(); // referensi dummy gateway
            $table->enum('status', ['pending', 'success', 'failed'])->default('success');
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
