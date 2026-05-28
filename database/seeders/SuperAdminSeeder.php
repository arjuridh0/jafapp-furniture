<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@jafapp.com'],
            [
                'name' => 'Super Admin JAFAPP',
                'password' => bcrypt('superadmin123'),
                'role' => 'superadmin',
                'phone' => '081234567890',
                'address' => 'Jepara, Jawa Tengah',
                'is_active' => true,
                'is_guest' => false,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@jafapp.com'],
            [
                'name' => 'Admin JAFAPP',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'phone' => '081234567891',
                'address' => 'Jepara, Jawa Tengah',
                'is_active' => true,
                'is_guest' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
