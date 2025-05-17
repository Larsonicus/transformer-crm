<?php

namespace Database\Seeders;

use App\Models\ClientRequest;
use App\Models\Partner;
use App\Models\Source;
use App\Models\User;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        $roleWorker = Role::create(['name' => 'worker']);
        $rolePartner = Role::create(['name' => 'partner']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleSource = Role::create(['name' => 'source']);

        $permissionReadRequest = Permission::create(['name' => 'read request']);
        $permissionDeleteRequest = Permission::create(['name' => 'delete request']);
        $permissionCreateRequest = Permission::create(['name' => 'create request']);
        $permissionUpdateRequest = Permission::create(['name' => 'update request']);

        $permissionReadUser = Permission::create(['name' => 'read user']);
        $permissionDeleteUser = Permission::create(['name' => 'delete user']);
        $permissionCreateUser = Permission::create(['name' => 'create user']);
        $permissionUpdateUser = Permission::create(['name' => 'update user']);

        $permissionReadPartner = Permission::create(['name' => 'read partner']);
        $permissionDeletePartner = Permission::create(['name' => 'delete partner']);
        $permissionCreatePartner = Permission::create(['name' => 'create partner']);
        $permissionUpdatePartner = Permission::create(['name' => 'update partner']);

        $permissionReadSource = Permission::create(['name' => 'read source']);
        $permissionDeleteSource = Permission::create(['name' => 'delete source']);
        $permissionCreateSource = Permission::create(['name' => 'create source']);
        $permissionUpdateSource = Permission::create(['name' => 'update source']);

        $permissionReadTask = Permission::create(['name' => 'read task']);
        $permissionDeleteTask = Permission::create(['name' => 'delete task']);
        $permissionCreateTask = Permission::create(['name' => 'create task']);
        $permissionUpdateTask = Permission::create(['name' => 'update task']);

        $permissionReadRequest->assignRole($roleWorker, $rolePartner, $roleAdmin);
        $permissionDeleteRequest->assignRole($roleAdmin);
        $permissionCreateRequest->assignRole($roleWorker, $roleAdmin);
        $permissionUpdateRequest->assignRole($roleWorker, $roleAdmin);

        $permissionReadUser->assignRole($roleWorker, $roleAdmin);
        $permissionDeleteUser->assignRole($roleAdmin);
        $permissionCreateUser->assignRole($roleAdmin);
        $permissionUpdateUser->assignRole($roleAdmin);

        $permissionReadPartner->assignRole($roleAdmin, $roleWorker);
        $permissionDeletePartner->assignRole($roleAdmin);
        $permissionCreatePartner->assignRole($roleAdmin, $roleWorker);
        $permissionUpdatePartner->assignRole($roleAdmin, $roleWorker);

        $permissionReadSource->assignRole($roleAdmin, $roleWorker);
        $permissionDeleteSource->assignRole($roleAdmin);
        $permissionCreateSource->assignRole($roleAdmin, $roleWorker);
        $permissionUpdateSource->assignRole($roleAdmin, $roleWorker);

        $permissionReadTask->assignRole($roleAdmin, $roleWorker, $rolePartner);
        $permissionDeleteTask->assignRole($roleAdmin);
        $permissionCreateTask->assignRole($roleAdmin, $roleWorker);
        $permissionUpdateTask->assignRole($roleAdmin, $roleWorker);


    }
}
