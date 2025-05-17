<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Navigation extends Component
{
    public $navigationItems = [];

    public function __construct()
    {
        $user = Auth::user();
        
        // Статистика
        $this->navigationItems['statistics'] = [
            'name' => 'Статистика',
            'route' => 'statistics.index',
            'icon' => 'chart-bar',
            'actions' => []
        ];
        
        // Заявки
        if ($user->can('read request')) {
            $this->navigationItems['requests'] = [
                'name' => 'Заявки',
                'route' => 'requests.index',
                'icon' => 'document-text',
                'actions' => [
                    'create' => $user->can('create request'),
                    'update' => $user->can('update request'),
                    'delete' => $user->can('delete request'),
                ]
            ];
        }

        // Задачи
        if ($user->can('read task')) {
            $this->navigationItems['tasks'] = [
                'name' => 'Задачи',
                'route' => 'tasks.index',
                'icon' => 'clipboard-list',
                'actions' => [
                    'create' => $user->can('create task'),
                    'update' => $user->can('update task'),
                    'delete' => $user->can('delete task'),
                ]
            ];
        }

        // Пользователи
        if ($user->can('read user')) {
            $this->navigationItems['users'] = [
                'name' => 'Пользователи',
                'route' => 'users.index',
                'icon' => 'users',
                'actions' => [
                    'create' => $user->can('create user'),
                    'update' => $user->can('update user'),
                    'delete' => $user->can('delete user'),
                ]
            ];
        }

        // Партнеры
        if ($user->can('read partner')) {
            $this->navigationItems['partners'] = [
                'name' => 'Партнеры',
                'route' => 'partners.index',
                'icon' => 'office-building',
                'actions' => [
                    'create' => $user->can('create partner'),
                    'update' => $user->can('update partner'),
                    'delete' => $user->can('delete partner'),
                ]
            ];
        }

        // Источники
        if ($user->can('read source')) {
            $this->navigationItems['sources'] = [
                'name' => 'Источники',
                'route' => 'sources.index',
                'icon' => 'collection',
                'actions' => [
                    'create' => $user->can('create source'),
                    'update' => $user->can('update source'),
                    'delete' => $user->can('delete source'),
                ]
            ];
        }

        // Скрипты обзвона
        if ($user->can('read call_script')) {
            $this->navigationItems['call-scripts'] = [
                'name' => 'Скрипты обзвона',
                'route' => 'call-scripts.index',
                'icon' => 'chat',
                'actions' => [
                    'create' => $user->can('create call_script'),
                    'update' => $user->can('update call_script'),
                    'delete' => $user->can('delete call_script'),
                ]
            ];
        }

        // Анкеты обзвона
        if ($user->can('read call_questionnaire')) {
            $this->navigationItems['call-questionnaires'] = [
                'name' => 'Анкеты обзвона',
                'route' => 'call-questionnaires.index',
                'icon' => 'clipboard-check',
                'actions' => [
                    'create' => $user->can('create call_questionnaire'),
                    'update' => $user->can('update call_questionnaire'),
                    'delete' => $user->can('delete call_questionnaire'),
                ]
            ];
        }

        // Ответы на обзвон
        if ($user->can('read call_response')) {
            $this->navigationItems['call-responses'] = [
                'name' => 'Ответы обзвона',
                'route' => 'call-responses.index',
                'icon' => 'phone',
                'actions' => [
                    'create' => $user->can('create call_response'),
                    'delete' => $user->can('delete call_response'),
                ]
            ];
        }
    }

    public function render()
    {
        return view('components.navigation');
    }
} 