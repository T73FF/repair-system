<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Создаём роли
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $technician = Role::create(['name' => 'technician']);
        $client = Role::create(['name' => 'client']);

        // Создаём основные права
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'manage clients']);
        Permission::create(['name' => 'manage equipment']);
        Permission::create(['name' => 'manage warehouse']);

        // Назначаем права
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo(['view orders', 'create orders', 'edit orders', 'manage clients', 'manage equipment']);
        $technician->givePermissionTo(['view orders', 'edit orders']);
        $client->givePermissionTo(['view orders']);
    }
}