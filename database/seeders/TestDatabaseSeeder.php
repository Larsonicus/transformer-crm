<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TestDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Создаем базовые роли для тестов
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'worker']);
        Role::create(['name' => 'partner']);
        Role::create(['name' => 'source']);
    }
} 