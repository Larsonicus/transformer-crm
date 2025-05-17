<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Partner;
use App\Enums\TaskStatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsService
{
    public function getGeneralStatistics()
    {
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        
        return [
            'total_tasks' => Task::count(),
            'tasks_this_month' => Task::where('created_at', '>=', $startOfMonth)->count(),
            'completed_tasks' => Task::where('status', TaskStatus::COMPLETED)->count(),
            'active_tasks' => Task::whereIn('status', [TaskStatus::PENDING, TaskStatus::IN_PROGRESS])->count(),
            'overdue_tasks' => Task::where('due_date', '<', $now)
                ->whereIn('status', [TaskStatus::PENDING, TaskStatus::IN_PROGRESS])
                ->count(),
            'total_users' => User::count(),
            'total_partners' => Partner::count(),
        ];
    }

    public function getTasksByStatus()
    {
        $statuses = Task::select('status', DB::raw('count(*) as total'))
            ->whereNotNull('status')
            ->groupBy('status')
            ->get();

        $result = [];
        foreach ($statuses as $status) {
            if ($status->status !== null) {
                $statusValue = $status->status->value;
                $result[$statusValue] = (int)$status->total;
            }
        }

        return $result;
    }

    public function getTasksCompletionTrend()
    {
        $last6Months = collect(range(5, 0))->map(function($i) {
            return Carbon::now()->startOfMonth()->subMonths($i);
        });

        $trend = [];
        foreach ($last6Months as $month) {
            $trend[$month->format('Y-m')] = [
                'completed' => Task::where('status', TaskStatus::COMPLETED)
                    ->whereYear('updated_at', $month->year)
                    ->whereMonth('updated_at', $month->month)
                    ->count(),
                'created' => Task::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        return $trend;
    }

    public function getTopPerformers()
    {
        return User::withCount(['assignedTasks' => function($query) {
            $query->where('status', TaskStatus::COMPLETED);
        }])
        ->orderByDesc('assigned_tasks_count')
        ->limit(5)
        ->get();
    }

    public function getPartnerStatistics()
    {
        return Partner::withCount(['tasks' => function($query) {
            $query->where('status', TaskStatus::COMPLETED);
        }])
        ->withCount(['tasks as active_tasks_count' => function($query) {
            $query->whereIn('status', [TaskStatus::PENDING, TaskStatus::IN_PROGRESS]);
        }])
        ->orderByDesc('tasks_count')
        ->limit(10)
        ->get();
    }
} 