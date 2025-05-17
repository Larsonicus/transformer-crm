<?php

namespace App\Http\Controllers;

use App\Models\CallQuestionnaire;
use App\Models\CallResponse;
use App\Models\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallResponseController extends Controller
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
        if (!Auth::user()->can('read call_response')) {
            abort(403, 'Unauthorized action.');
        }

        $responses = CallResponse::with(['questionnaire', 'user', 'clientRequest'])->latest()->paginate(10);
        return view('call-responses.index', compact('responses'));
    }

    /**
     * Show the form for creating a new response.
     */
    public function create()
    {
        if (!Auth::user()->can('create call_response')) {
            abort(403, 'Unauthorized action.');
        }

        $questionnaires = CallQuestionnaire::where('is_active', true)->with('callScript')->get();
        $clientRequests = ClientRequest::latest()->get();
        
        return view('call-responses.create', compact('questionnaires', 'clientRequests'));
    }

    /**
     * Store a newly created response in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create call_response')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'call_questionnaire_id' => 'required|exists:call_questionnaires,id',
            'client_request_id' => 'nullable|exists:client_requests,id',
            'answers' => 'required|array',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:completed,partial,failed'
        ]);

        $validated['user_id'] = Auth::id();

        CallResponse::create($validated);

        return redirect()->route('call-responses.index')
            ->with('success', 'Ответ на скрипт успешно сохранен');
    }

    /**
     * Display the specified response.
     */
    public function show(CallResponse $callResponse)
    {
        if (!Auth::user()->can('read call_response')) {
            abort(403, 'Unauthorized action.');
        }

        $callResponse->load(['questionnaire.callScript', 'user', 'clientRequest']);
        
        return view('call-responses.show', compact('callResponse'));
    }

    /**
     * Show the form for filling a questionnaire.
     */
    public function fill(CallQuestionnaire $questionnaire, ?ClientRequest $clientRequest = null)
    {
        if (!Auth::user()->can('create call_response')) {
            abort(403, 'Unauthorized action.');
        }

        $questionnaire->load('callScript');
        
        return view('call-responses.fill', compact('questionnaire', 'clientRequest'));
    }

    /**
     * Remove the specified response from storage.
     */
    public function destroy(CallResponse $callResponse)
    {
        if (!Auth::user()->can('delete call_response')) {
            abort(403, 'Unauthorized action.');
        }

        $callResponse->delete();

        return redirect()->route('call-responses.index')
            ->with('success', 'Ответ на скрипт успешно удален');
    }
} 