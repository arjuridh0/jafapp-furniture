<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('order_number', 30)->unique()->comment('Format: JAF-YYYYMMDD-XXXX');
            $table->enum('type', ['regular', 'custom'])->default('regular');
            $table->enum('status', [
                'pending_payment',
                'payment_confirmed',
                'order_received',
                'material_preparation',
                'in_production',
                'finishing',
                'quality_check',
                'ready_to_ship',
                'completed',
                'cancelled',
            ])->default('pending_payment');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->text('shipping_address');
            // Guest info snapshot (copied from user at order creation time)
            $table->string('guest_name', 100)->nullable();
            $table->string('guest_email', 150)->nullable();
            $table->string('guest_phone', 20)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
