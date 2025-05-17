<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Partner;
use App\Enums\TaskStatus;
use App\Exports\TasksExport;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->middleware(['auth']);
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->middleware('task.auth:read');
        $tasks = $this->taskService->getTasksQuery()->latest()->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->middleware('task.auth:create');
        
        $users = User::all();
        $partners = Partner::all();
        $statuses = [
            TaskStatus::PENDING->value => 'В ожидании',
            TaskStatus::IN_PROGRESS->value => 'В работе',
            TaskStatus::COMPLETED->value => 'Завершено',
        ];

        return view('tasks.create', compact('users', 'partners', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $this->middleware('task.auth:create');
        
        $task = $this->taskService->createTask($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Задача успешно создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->middleware('task.auth:read');
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->middleware('task.auth:update');
        
        $users = User::all();
        $partners = Partner::all();
        $statuses = [
            TaskStatus::PENDING->value => 'В ожидании',
            TaskStatus::IN_PROGRESS->value => 'В работе',
            TaskStatus::COMPLETED->value => 'Завершено',
        ];

        return view('tasks.edit', compact('task', 'users', 'partners', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->middleware('task.auth:update');
        
        $this->taskService->updateTask($task, $request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Задача успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->middleware('task.auth:delete');
        
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Задача успешно удалена');
    }

    public function export()
    {
        $this->middleware('task.auth:read');
        
        $tasks = $this->taskService->getTasksQuery();
        return Excel::download(new TasksExport($tasks), 'tasks.xlsx');
    }
}
