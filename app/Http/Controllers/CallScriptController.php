<?php

namespace App\Http\Controllers;

use App\Models\CallScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallScriptController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->can('read call_script')) {
            abort(403, 'Unauthorized action.');
        }

        $scripts = CallScript::latest()->paginate(10);
        return view('call-scripts.index', compact('scripts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('create call_script')) {
            abort(403, 'Unauthorized action.');
        }

        return view('call-scripts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create call_script')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'sometimes|boolean'
        ]);

        $validated['created_by'] = Auth::id();
        
        CallScript::create($validated);

        return redirect()->route('call-scripts.index')
            ->with('success', 'Скрипт обзвона успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(CallScript $callScript)
    {
        if (!Auth::user()->can('read call_script')) {
            abort(403, 'Unauthorized action.');
        }

        return view('call-scripts.show', compact('callScript'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallScript $callScript)
    {
        if (!Auth::user()->can('update call_script')) {
            abort(403, 'Unauthorized action.');
        }

        return view('call-scripts.edit', compact('callScript'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallScript $callScript)
    {
        if (!Auth::user()->can('update call_script')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'sometimes|boolean'
        ]);

        $callScript->update($validated);

        return redirect()->route('call-scripts.index')
            ->with('success', 'Скрипт обзвона успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallScript $callScript)
    {
        if (!Auth::user()->can('delete call_script')) {
            abort(403, 'Unauthorized action.');
        }

        $callScript->delete();

        return redirect()->route('call-scripts.index')
            ->with('success', 'Скрипт обзвона успешно удален');
    }
} 