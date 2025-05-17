<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function getTasksQuery()
    {
        $query = Task::query();

        if (Auth::user()->hasRole('partner')) {
            $query->where('partner_id', Auth::user()->id);
        }

        return $query;
    }

    public function createTask(array $data): Task
    {
        $maxOrder = Task::where('status', $data['status'])->max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        return Task::create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        if ($task->status !== $data['status']) {
            $maxOrder = Task::where('status', $data['status'])->max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }

        $task->update($data);
        return $task;
    }
} 