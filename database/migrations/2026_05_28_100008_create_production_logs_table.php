<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
                'order_received',
                'material_preparation',
                'in_production',
                'finishing',
                'quality_check',
                'ready_to_ship',
                'completed',
            ]);
            $table->text('notes')->nullable();
            $table->string('photo', 255)->nullable()->comment('Progress photo path');
            $table->foreignId('updated_by')->constrained('users')->onDelete('restrict')
                  ->comment('Admin who updated this status');
            $table->timestamp('created_at')->nullable();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_logs');
    }
};
