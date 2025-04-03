<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Enums\TaskStatus;

class TaskBoard extends Component
{
    public $tasks;

    protected $listeners = ['taskUpdated' => 'refreshTasks'];

    public function mount()
    {
        $this->refreshTasks();
    }

    public function refreshTasks()
    {
        $this->tasks = Task::orderBy('order')->get()->groupBy('status');
    }

    public function updateTaskOrder($taskId, $newStatus, $newOrder)
    {
        $task = Task::find($taskId);

        // Обновляем порядок всех задач в исходном статусе
        Task::where('status', $task->status)
            ->where('order', '>', $task->order)
            ->decrement('order');

        // Обновляем порядок всех задач в новом статусе
        Task::where('status', $newStatus)
            ->where('order', '>=', $newOrder)
            ->increment('order');

        // Обновляем текущую задачу
        $task->update([
            'status' => $newStatus,
            'order' => $newOrder
        ]);

        $this->refreshTasks();
    }

    public function render()
    {
        return view('livewire.task-board', [
            'statuses' => TaskStatus::cases(),
            'groupedTasks' => $this->tasks
        ]);
    }
}
