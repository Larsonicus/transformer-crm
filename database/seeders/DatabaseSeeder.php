<?php

namespace Database\Seeders;

use App\Models\ClientRequest;
use App\Models\Partner;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    public function run()
    {

        $this->call([
            TaskSeeder::class,
        ]);
        // Пользователи
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        // Партнёры
        Partner::create(['name' => 'ООО "Ромашка"', 'contact_email' => 'romashka@mail.ru']);
        Partner::create(['name' => 'ИП Иванов', 'contact_email' => 'ivanov@mail.ru']);

        // Источники
        Source::create(['name' => 'Сайт']);
        Source::create(['name' => 'Телефонный звонок']);

        // Заявки
        ClientRequest::factory(15)->create();
    }
}
