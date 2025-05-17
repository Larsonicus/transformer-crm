<?php

namespace App\Livewire\Request;

use Illuminate\Support\Facades\Auth;

trait RequestFormState
{
    public $title;
    public $description;
    public $user_id;
    public $partner_id;
    public $source_id;
    public $status = 'new';

    // Флаги для прав доступа
    public $canManageUsers = false;
    public $canManagePartners = false;
    public $canManageSources = false;
    public $canChangeStatus = false;

    public function initializeRequestFormState()
    {
        // Инициализация прав доступа
        $user = Auth::user();
        $this->canManageUsers = $user->can('read user');
        $this->canManagePartners = $user->can('read partner');
        $this->canManageSources = $user->can('read source');
        
        // Если пользователь партнер, автоматически устанавливаем partner_id
        if ($user->hasRole('partner')) {
            $this->partner_id = $user->id;
        }

        // Устанавливаем значения по умолчанию
        if (!$this->canManageUsers) {
            $this->user_id = $user->id;
        }
    }

    public function getRules()
    {
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'user_id' => 'required|exists:users,id',
            'partner_id' => 'required|exists:partners,id',
            'source_id' => 'required|exists:sources,id',
            'status' => 'required|in:new,in_progress,completed'
        ];
    }

    public function getValidationMessages()
    {
        return [
            'title.required' => 'Название заявки обязательно для заполнения',
            'title.min' => 'Название должно содержать минимум 5 символов',
            'description.required' => 'Описание заявки обязательно для заполнения',
            'description.min' => 'Описание должно содержать минимум 10 символов',
            'user_id.required' => 'Необходимо выбрать пользователя',
            'user_id.exists' => 'Выбранный пользователь не существует',
            'partner_id.required' => 'Необходимо выбрать партнера',
            'partner_id.exists' => 'Выбранный партнер не существует',
            'source_id.required' => 'Необходимо выбрать источник',
            'source_id.exists' => 'Выбранный источник не существует',
        ];
    }
} 