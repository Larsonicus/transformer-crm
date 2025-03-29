<?php

namespace App\Livewire;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Component;

class TaskList extends Component
{
    public Collection $tasks;

    public function mount()
    {
        $this->tasks = Task::all();
    }

    public function render()
    {
        $groupedTasks = $this->tasks->groupBy(fn($task) => $task->status->value);
        $statuses = TaskStatus::cases();

        return view('livewire.task-list', compact('groupedTasks', 'statuses'));
    }
}
