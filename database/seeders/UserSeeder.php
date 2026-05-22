<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём админа
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone' => '79991234567',
                'role' => 'admin',
            ]
        );
        $admin->assignRole('admin');

        // Создаём тестового клиента (необязательно)
        $client = User::firstOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Test Client',
                'password' => Hash::make('password'),
                'phone' => '79998887766',
                'role' => 'client',
            ]
        );
        $client->assignRole('client');
    }
}