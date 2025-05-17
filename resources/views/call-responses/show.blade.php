<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Просмотр ответов на анкету') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('call-questionnaires.show', $callResponse->questionnaire) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('К анкете') }}
                </a>
                <a href="{{ route('call-responses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Назад к списку') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Информация об анкете') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Анкета:') }}</p>
                                <p class="text-md font-medium">
                                    <a href="{{ route('call-questionnaires.show', $callResponse->questionnaire) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $callResponse->questionnaire->title }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Скрипт:') }}</p>
                                <p class="text-md font-medium">
                                    @if($callResponse->questionnaire->callScript)
                                        <a href="{{ route('call-scripts.show', $callResponse->questionnaire->callScript) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $callResponse->questionnaire->callScript->title }}
                                        </a>
                                    @else
                                        <span class="text-red-600">{{ __('Скрипт не найден') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Дата:') }}</p>
                                <p class="text-md">{{ $callResponse->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Статус:') }}</p>
                                <p class="text-md">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($callResponse->status === 'completed') bg-green-100 text-green-800
                                        @elseif($callResponse->status === 'partial') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($callResponse->status === 'completed')
                                            {{ __('Завершён') }}
                                        @elseif($callResponse->status === 'partial')
                                            {{ __('Частично') }}
                                        @else
                                            {{ __('Не удалось') }}
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Оператор:') }}</p>
                                <p class="text-md">{{ $callResponse->user->name ?? __('Неизвестно') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Заявка:') }}</p>
                                <p class="text-md">
                                    @if($callResponse->clientRequest)
                                        <a href="{{ route('requests.show', $callResponse->clientRequest) }}" class="text-blue-600 hover:text-blue-900">
                                            #{{ $callResponse->clientRequest->id }} - {{ $callResponse->clientRequest->title }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">{{ __('Нет') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($callResponse->notes)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Заметки по звонку') }}</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            {{ $callResponse->notes }}
                        </div>
                    </div>
                    @endif

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Ответы на вопросы') }}</h3>
                        @if(!$callResponse->answers || empty($callResponse->answers))
                            <div class="bg-yellow-50 p-4 rounded-lg text-yellow-800">
                                {{ __('Нет данных об ответах') }}
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($callResponse->answers as $index => $answer)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="text-md font-medium">{{ $index + 1 }}. {{ $answer['question'] ?? 'Вопрос не указан' }}</h4>
                                        
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">{{ __('Ответ:') }}</p>
                                            
                                            @if($answer['type'] === 'text')
                                                <p class="mt-1 p-2 bg-white rounded-md border border-gray-200">
                                                    {{ $answer['value'] ?? __('Нет ответа') }}
                                                </p>
                                            
                                            @elseif($answer['type'] === 'radio')
                                                <p class="mt-1 p-2 bg-white rounded-md border border-gray-200">
                                                    {{ $answer['value'] ?? __('Нет ответа') }}
                                                </p>
                                                
                                            @elseif($answer['type'] === 'checkbox')
                                                @if(is_array($answer['value']) && !empty($answer['value']))
                                                    <ul class="list-disc list-inside ml-2 mt-1 p-2 bg-white rounded-md border border-gray-200">
                                                        @foreach($answer['value'] as $checkboxValue)
                                                            <li>{{ $checkboxValue }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="mt-1 p-2 bg-white rounded-md border border-gray-200">
                                                        {{ __('Не выбрано') }}
                                                    </p>
                                                @endif
                                                
                                            @elseif($answer['type'] === 'select')
                                                <p class="mt-1 p-2 bg-white rounded-md border border-gray-200">
                                                    {{ $answer['value'] ?? __('Не выбрано') }}
                                                </p>
                                            @else
                                                <p class="mt-1 p-2 bg-white rounded-md border border-gray-200">
                                                    {{ is_array($answer['value']) ? implode(', ', $answer['value']) : ($answer['value'] ?? __('Нет ответа')) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 