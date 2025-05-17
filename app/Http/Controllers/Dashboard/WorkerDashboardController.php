<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use App\Models\Task;
use App\Models\Partner;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::user()->hasRole('worker')) {
            return redirect()->route('dashboard');
        }

        $requests = ClientRequest::latest()->paginate(10);
        $tasks = Task::where('assigned_to', auth()->id())->latest()->paginate(10);
        $partners = Partner::all();
        $sources = Source::all();

        return view('dashboard.worker.index', compact('requests', 'tasks', 'partners', 'sources'));
    }
} 