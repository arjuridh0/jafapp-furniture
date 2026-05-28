<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->onDelete('restrict');
            $table->string('midtrans_transaction_id', 100)->nullable()->unique();
            $table->string('snap_token', 255)->nullable();
            $table->string('payment_type', 50)->nullable()->comment('gopay, bank_transfer, qris, etc.');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->json('raw_response')->nullable()->comment('Full Midtrans webhook response');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
