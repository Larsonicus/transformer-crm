<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Заполнение анкеты обзвона') }}
            </h2>
            <a href="{{ route('call-questionnaires.show', $questionnaire) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Назад к анкете') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Информация о клиенте -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Информация о звонке') }}</h3>
                            <form method="POST" action="{{ route('call-responses.store') }}" id="responseForm">
                                @csrf
                                <input type="hidden" name="call_questionnaire_id" value="{{ $questionnaire->id }}">
                                
                                @if($clientRequest)
                                    <input type="hidden" name="client_request_id" value="{{ $clientRequest->id }}">
                                    <div class="mb-4">
                                        <x-input-label :value="__('Заявка')" />
                                        <div class="bg-gray-50 p-2 rounded-md">
                                            <p>#{{ $clientRequest->id }} - {{ $clientRequest->title }}</p>
                                            <p class="text-sm text-gray-600">{{ $clientRequest->client_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $clientRequest->client_phone }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <x-input-label for="client_request_id" :value="__('Заявка (необязательно)')" />
                                        <select id="client_request_id" name="client_request_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">{{ __('Выберите заявку') }}</option>
                                            @foreach(\App\Models\ClientRequest::latest()->take(30)->get() as $request)
                                                <option value="{{ $request->id }}">
                                                    #{{ $request->id }} - {{ $request->title }} ({{ $request->client_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                
                                <div class="mb-4">
                                    <x-input-label for="status" :value="__('Статус звонка')" />
                                    <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="completed">{{ __('Завершён успешно') }}</option>
                                        <option value="partial">{{ __('Частично завершён') }}</option>
                                        <option value="failed">{{ __('Не удалось связаться') }}</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="notes" :value="__('Заметки по звонку')" />
                                    <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                                </div>
                            
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Скрипт обзвона') }}</h3>
                            <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-wrap text-sm max-h-[300px] overflow-y-auto">
                                {{ $questionnaire->callScript->content ?? __('Скрипт не найден') }}
                            </div>
                            <div class="mt-4 text-right">
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="window.open('{{ route('call-scripts.show', $questionnaire->callScript) }}', '_blank')">
                                    {{ __('Открыть скрипт в новом окне') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Анкета -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Анкета:') }} {{ $questionnaire->title }}</h3>
                    
                    <div class="space-y-6">
                        @if(!$questionnaire->questions || empty($questionnaire->questions))
                            <div class="bg-yellow-50 p-4 rounded-lg text-yellow-800">
                                {{ __('В анкете не определены вопросы') }}
                            </div>
                        @else
                            @foreach($questionnaire->questions as $index => $question)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-md font-medium">{{ $index + 1 }}. {{ $question['text'] }}</h4>
                                    
                                    <div class="mt-2">
                                        @if($question['type'] === 'text')
                                            <textarea 
                                                name="answers[{{ $index }}][value]" 
                                                rows="2" 
                                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                                {{ isset($question['required']) && $question['required'] ? 'required' : '' }}
                                            ></textarea>
                                            <input type="hidden" name="answers[{{ $index }}][question]" value="{{ $question['text'] }}">
                                            <input type="hidden" name="answers[{{ $index }}][type]" value="text">
                                        
                                        @elseif($question['type'] === 'radio')
                                            <div class="space-y-2">
                                                @foreach($question['options'] as $optionIndex => $option)
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="radio" 
                                                            id="question_{{ $index }}_option_{{ $optionIndex }}" 
                                                            name="answers[{{ $index }}][value]" 
                                                            value="{{ $option }}" 
                                                            class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                            {{ isset($question['required']) && $question['required'] ? 'required' : '' }}
                                                        >
                                                        <label for="question_{{ $index }}_option_{{ $optionIndex }}" class="ml-2 text-sm text-gray-700">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="answers[{{ $index }}][question]" value="{{ $question['text'] }}">
                                            <input type="hidden" name="answers[{{ $index }}][type]" value="radio">
                                            
                                        @elseif($question['type'] === 'checkbox')
                                            <div class="space-y-2">
                                                @foreach($question['options'] as $optionIndex => $option)
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="checkbox" 
                                                            id="question_{{ $index }}_option_{{ $optionIndex }}" 
                                                            name="answers[{{ $index }}][value][]" 
                                                            value="{{ $option }}" 
                                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                        >
                                                        <label for="question_{{ $index }}_option_{{ $optionIndex }}" class="ml-2 text-sm text-gray-700">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="answers[{{ $index }}][question]" value="{{ $question['text'] }}">
                                            <input type="hidden" name="answers[{{ $index }}][type]" value="checkbox">
                                            
                                        @elseif($question['type'] === 'select')
                                            <select 
                                                name="answers[{{ $index }}][value]" 
                                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                {{ isset($question['required']) && $question['required'] ? 'required' : '' }}
                                            >
                                                <option value="">{{ __('Выберите вариант') }}</option>
                                                @foreach($question['options'] as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="answers[{{ $index }}][question]" value="{{ $question['text'] }}">
                                            <input type="hidden" name="answers[{{ $index }}][type]" value="select">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('call-questionnaires.show', $questionnaire) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Отмена') }}
                        </a>
                        <x-primary-button class="ml-4" form="responseForm">
                            {{ __('Сохранить ответы') }}
                        </x-primary-button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 