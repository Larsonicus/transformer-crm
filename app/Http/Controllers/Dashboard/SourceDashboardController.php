<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SourceDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::user()->hasRole('source')) {
            return redirect()->route('dashboard');
        }

        $requests = ClientRequest::where('source_id', auth()->user()->source_id)
            ->latest()
            ->paginate(10);

        return view('dashboard.source.index', compact('requests'));
    }
} 