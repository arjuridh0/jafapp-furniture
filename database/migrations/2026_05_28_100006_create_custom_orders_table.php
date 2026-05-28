<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null')
                  ->comment('Filled after admin approves and converts to regular order');
            $table->text('description');
            $table->string('dimensions', 100)->nullable();
            $table->string('material', 100)->nullable();
            $table->string('finishing', 100)->nullable();
            $table->string('color', 50)->nullable();
            $table->json('ref_images')->nullable()->comment('Array of reference image file paths');
            $table->text('admin_notes')->nullable();
            $table->decimal('agreed_price', 15, 2)->nullable()->comment('Set by admin on approval');
            $table->enum('status', [
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'converted_to_order',
            ])->default('submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};
