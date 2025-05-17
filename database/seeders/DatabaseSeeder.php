<?php

namespace Database\Seeders;

use App\Models\ClientRequest;
use App\Models\Partner;
use App\Models\Source;
use App\Models\User;
use App\Models\Task;
use App\Enums\TaskStatus;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем роли
        $roleWorker = Role::create(['name' => 'worker']);
        $rolePartner = Role::create(['name' => 'partner']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleSource = Role::create(['name' => 'source']);

        // Пользователи
        $admin = User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'position' => 'Администратор'
        ]);
        
        // Создаем тестового партнера
        $partner = User::create([
            'name' => 'Partner',
            'email' => 'partner@example.com',
            'password' => bcrypt('password')
        ]);

        // Назначаем роли
        $admin->assignRole('admin');
        $partner->assignRole('partner');

        // Партнёры
        Partner::create(['name' => 'ООО "Ромашка"', 'contact_email' => 'romashka@mail.ru']);
        Partner::create(['name' => 'ИП Иванов', 'contact_email' => 'ivanov@mail.ru']);

        // Источники
        Source::create(['name' => 'Сайт']);
        Source::create(['name' => 'Телефонный звонок']);

        // Заявки
        ClientRequest::factory(15)->create();

        // Базовые разрешения
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

        // Разрешения для скриптов обзвона
        $permissionReadCallScript = Permission::create(['name' => 'read call_script']);
        $permissionDeleteCallScript = Permission::create(['name' => 'delete call_script']);
        $permissionCreateCallScript = Permission::create(['name' => 'create call_script']);
        $permissionUpdateCallScript = Permission::create(['name' => 'update call_script']);

        $permissionReadCallQuestionnaire = Permission::create(['name' => 'read call_questionnaire']);
        $permissionDeleteCallQuestionnaire = Permission::create(['name' => 'delete call_questionnaire']);
        $permissionCreateCallQuestionnaire = Permission::create(['name' => 'create call_questionnaire']);
        $permissionUpdateCallQuestionnaire = Permission::create(['name' => 'update call_questionnaire']);

        $permissionReadCallResponse = Permission::create(['name' => 'read call_response']);
        $permissionDeleteCallResponse = Permission::create(['name' => 'delete call_response']);
        $permissionCreateCallResponse = Permission::create(['name' => 'create call_response']);
        $permissionUpdateCallResponse = Permission::create(['name' => 'update call_response']);

        // Назначаем базовые разрешения
        $roleWorker->givePermissionTo([
            'read request', 'create request', 'update request',
            'read user',
            'read partner', 'create partner', 'update partner',
            'read source', 'create source', 'update source',
            'read task', 'create task', 'update task',
            'read call_script',
            'read call_questionnaire',
            'read call_response', 'create call_response', 'delete call_response'
        ]);

        $rolePartner->givePermissionTo([
            'read request',
            'read task'
        ]);

        $roleAdmin->givePermissionTo([
            'read request', 'create request', 'update request', 'delete request',
            'read user', 'create user', 'update user', 'delete user',
            'read partner', 'create partner', 'update partner', 'delete partner',
            'read source', 'create source', 'update source', 'delete source',
            'read task', 'create task', 'update task', 'delete task',
            'read call_script', 'create call_script', 'update call_script', 'delete call_script',
            'read call_questionnaire', 'create call_questionnaire', 'update call_questionnaire', 'delete call_questionnaire',
            'read call_response', 'create call_response', 'delete call_response'
        ]);

        // Запускаем остальные сидеры
        $this->call([
            CallScriptSeeder::class, // Добавляем сидер для скриптов обзвона
        ]);

        // Create test users
        $engineer = User::create([
            'name' => 'Инженер',
            'email' => 'engineer@example.com',
            'password' => Hash::make('password'),
            'position' => 'Инженер'
        ]);
        $engineer->assignRole('worker');

        $manager = User::create([
            'name' => 'Менеджер',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'position' => 'Менеджер'
        ]);
        $manager->assignRole('worker');

        // Create test partners
        $partner1 = Partner::create([
            'name' => 'ООО "ЭнергоТранс"',
            'contact_email' => 'contact@energotrans.com',
            'phone' => '+7 (999) 123-45-67',
            'address' => 'г. Москва, ул. Энергетическая, 1'
        ]);

        $partner2 = Partner::create([
            'name' => 'АО "ТрансформерСервис"',
            'contact_email' => 'info@transformerservice.com',
            'phone' => '+7 (999) 765-43-21',
            'address' => 'г. Санкт-Петербург, пр. Энергетиков, 10'
        ]);

        // Create test tasks
        // Pending tasks
        Task::create([
            'title' => 'Диагностика трансформатора ТМ-1000',
            'description' => 'Провести полную диагностику трансформатора ТМ-1000 на подстанции №5',
            'status' => TaskStatus::PENDING,
            'order' => 1,
            'due_date' => now()->addDays(5),
            'assigned_to' => $engineer->id,
            'partner_id' => $partner1->id
        ]);

        Task::create([
            'title' => 'Замена масла в трансформаторе',
            'description' => 'Плановая замена масла в трансформаторе на объекте заказчика',
            'status' => TaskStatus::PENDING,
            'order' => 2,
            'due_date' => now()->addDays(7),
            'assigned_to' => $engineer->id,
            'partner_id' => $partner2->id
        ]);

        // In Progress tasks
        Task::create([
            'title' => 'Ремонт системы охлаждения',
            'description' => 'Ремонт и обслуживание системы охлаждения силового трансформатора',
            'status' => TaskStatus::IN_PROGRESS,
            'order' => 1,
            'due_date' => now()->addDays(3),
            'assigned_to' => $engineer->id,
            'partner_id' => $partner1->id
        ]);

        Task::create([
            'title' => 'Модернизация защитной системы',
            'description' => 'Установка новых компонентов защиты на трансформаторной подстанции',
            'status' => TaskStatus::IN_PROGRESS,
            'order' => 2,
            'due_date' => now()->addDays(4),
            'assigned_to' => $engineer->id,
            'partner_id' => $partner2->id
        ]);

        // Completed tasks
        Task::create([
            'title' => 'Профилактический осмотр',
            'description' => 'Проведен плановый осмотр и обслуживание трансформаторного оборудования',
            'status' => TaskStatus::COMPLETED,
            'order' => 1,
            'due_date' => now()->subDays(1),
            'assigned_to' => $engineer->id,
            'partner_id' => $partner1->id
        ]);

        Task::create([
            'title' => 'Настройка РПН',
            'description' => 'Выполнена настройка устройства РПН на силовом трансформаторе',
            'status' => TaskStatus::COMPLETED,
            'order' => 2,
            'due_date' => now()->subDays(2),
            'assigned_to' => $engineer->id,
            'partner_id' => $partner2->id
        ]);
    }
}
