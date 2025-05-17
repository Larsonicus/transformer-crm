<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::user()->hasRole('partner')) {
            return redirect()->route('dashboard');
        }

        $requests = ClientRequest::where('partner_id', auth()->user()->partner_id)
            ->latest()
            ->paginate(10);
        $tasks = Task::where('partner_id', auth()->user()->partner_id)
            ->latest()
            ->paginate(10);

        return view('dashboard.partner.index', compact('requests', 'tasks'));
    }
} 