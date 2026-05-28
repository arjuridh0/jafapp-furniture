<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['customer', 'admin', 'superadmin'])->default('customer')->after('email');
            $table->string('phone', 20)->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('address');
            $table->boolean('is_guest')->default(false)->after('is_active');
            $table->string('activation_token', 100)->nullable()->after('is_guest');
            $table->timestamp('activation_token_expires_at')->nullable()->after('activation_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'address',
                'is_active',
                'is_guest',
                'activation_token',
                'activation_token_expires_at',
            ]);
        });
    }
};
