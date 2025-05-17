<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Enums\TaskStatus;
use Illuminate\Support\Facades\DB;

class TaskList extends Component
{
    public $tasks = [];
    public $statuses = [];
    public $successMessage;
    public $errorMessage;

    protected $listeners = ['refreshTasks' => 'loadTasks'];

    public function mount()
    {
        $this->initializeStatuses();
        $this->loadTasks();
    }

    protected function initializeStatuses()
    {
        $this->statuses = [
            TaskStatus::PENDING->value => 'В ожидании',
            TaskStatus::IN_PROGRESS->value => 'В работе',
            TaskStatus::COMPLETED->value => 'Завершено',
        ];
    }

    public function loadTasks()
    {
        if (empty($this->statuses)) {
            $this->initializeStatuses();
        }

        $tasks = Task::with(['assignedUser', 'partner'])
            ->orderBy('status')
            ->orderBy('order')
            ->get();

        // Initialize empty arrays for each status
        $this->tasks = array_fill_keys(array_keys($this->statuses), []);

        // Group tasks by status
        foreach ($tasks as $task) {
            $status = $task->status->value;
            $this->tasks[$status][] = $task;
        }
    }

    public function updateTaskStatus($taskId, $newStatus, $order)
    {
        try {
            DB::beginTransaction();

            $task = Task::findOrFail($taskId);
            $oldStatus = $task->status->value;
            
            // Cast newStatus to TaskStatus enum
            $newStatus = TaskStatus::from($newStatus);
            
            // Update orders in the old status column
            if ($oldStatus === $newStatus->value) {
                // Reordering within the same status
                $this->reorderTasksInSameStatus($task, $order);
            } else {
                // Moving to a different status
                $this->reorderTasksForStatusChange($task, $newStatus->value, $order);
            }

            DB::commit();
            
            $this->successMessage = 'Задача успешно обновлена';
            $this->dispatch('task-updated');
            $this->loadTasks();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'Произошла ошибка при обновлении задачи';
            logger()->error('Task update failed: ' . $e->getMessage());
        }
    }

    protected function reorderTasksInSameStatus($task, $newOrder)
    {
        $oldOrder = $task->order;
        
        if ($newOrder > $oldOrder) {
            // Moving down - update tasks in between
            Task::where('status', $task->status)
                ->where('order', '>', $oldOrder)
                ->where('order', '<=', $newOrder)
                ->decrement('order');
        } else {
            // Moving up - update tasks in between
            Task::where('status', $task->status)
                ->where('order', '>=', $newOrder)
                ->where('order', '<', $oldOrder)
                ->increment('order');
        }

        $task->update(['order' => $newOrder]);
    }

    protected function reorderTasksForStatusChange($task, $newStatus, $newOrder)
    {
        // Make space in the new status column
        Task::where('status', $newStatus)
            ->where('order', '>=', $newOrder)
            ->increment('order');

        // Close the gap in the old status column
        Task::where('status', $task->status)
            ->where('order', '>', $task->order)
            ->decrement('order');

        // Update the task
        $task->update([
            'status' => $newStatus,
            'order' => $newOrder
        ]);
    }

    public function render()
    {
        return view('livewire.tasks.task-list');
    }
} 