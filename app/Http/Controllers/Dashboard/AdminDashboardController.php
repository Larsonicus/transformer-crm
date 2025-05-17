<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use App\Models\Task;
use App\Models\User;
use App\Models\Partner;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $stats = [
            'total_requests' => ClientRequest::count(),
            'total_users' => User::count(),
            'total_partners' => Partner::count(),
            'total_sources' => Source::count(),
            'total_tasks' => Task::count(),
        ];

        $recent_requests = ClientRequest::latest()->take(5)->get()->map(function($request) {
            if (!$request->created_at instanceof Carbon) {
                $request->created_at = Carbon::parse($request->created_at);
            }
            return $request;
        });

        $recent_tasks = Task::latest()->take(5)->get()->map(function($task) {
            if (!$task->due_date instanceof Carbon) {
                $task->due_date = $task->due_date ? Carbon::parse($task->due_date) : null;
            }
            return $task;
        });

        $recent_users = User::latest()->take(5)->get();
        $all_roles = Role::all();

        return view('dashboard.admin.index', compact('stats', 'recent_requests', 'recent_tasks', 'recent_users', 'all_roles'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        // Удаляем текущие роли и назначаем новую
        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => "Роль пользователя {$user->name} успешно обновлена"
        ]);
    }
} 