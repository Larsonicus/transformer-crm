<?php

namespace App\Http\Controllers;

use App\Models\CallQuestionnaire;
use App\Models\CallScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallQuestionnaireController extends Controller
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
        if (!Auth::user()->can('read call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        $questionnaires = CallQuestionnaire::with('callScript')->latest()->paginate(10);
        return view('call-questionnaires.index', compact('questionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('create call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        $scripts = CallScript::where('is_active', true)->get();
        return view('call-questionnaires.create', compact('scripts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'call_script_id' => 'required|exists:call_scripts,id',
            'title' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:text,radio,checkbox,select',
            'questions.*.options' => 'required_if:questions.*.type,radio,checkbox,select|array',
            'questions.*.required' => 'sometimes|boolean'
        ]);

        CallQuestionnaire::create($validated);

        return redirect()->route('call-questionnaires.index')
            ->with('success', 'Анкета успешно создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(CallQuestionnaire $callQuestionnaire)
    {
        if (!Auth::user()->can('read call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        return view('call-questionnaires.show', compact('callQuestionnaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallQuestionnaire $callQuestionnaire)
    {
        if (!Auth::user()->can('update call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        $scripts = CallScript::where('is_active', true)->get();
        return view('call-questionnaires.edit', compact('callQuestionnaire', 'scripts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallQuestionnaire $callQuestionnaire)
    {
        if (!Auth::user()->can('update call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'call_script_id' => 'required|exists:call_scripts,id',
            'title' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:text,radio,checkbox,select',
            'questions.*.options' => 'required_if:questions.*.type,radio,checkbox,select|array',
            'questions.*.required' => 'sometimes|boolean'
        ]);

        $callQuestionnaire->update($validated);

        return redirect()->route('call-questionnaires.index')
            ->with('success', 'Анкета успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallQuestionnaire $callQuestionnaire)
    {
        if (!Auth::user()->can('delete call_questionnaire')) {
            abort(403, 'Unauthorized action.');
        }

        $callQuestionnaire->delete();

        return redirect()->route('call-questionnaires.index')
            ->with('success', 'Анкета успешно удалена');
    }
} 