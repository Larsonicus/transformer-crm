<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Просмотр анкеты обзвона') }}
            </h2>
            <div class="flex space-x-2">
                @can('update call_questionnaire')
                <a href="{{ route('call-questionnaires.edit', $callQuestionnaire) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Редактировать') }}
                </a>
                @endcan
                @can('create call_response')
                <a href="{{ route('call-responses.fill', $callQuestionnaire) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Заполнить анкету') }}
                </a>
                @endcan
                <a href="{{ route('call-questionnaires.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                                <p class="text-sm text-gray-600">{{ __('Название:') }}</p>
                                <p class="text-md font-medium">{{ $callQuestionnaire->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Скрипт:') }}</p>
                                <p class="text-md font-medium">
                                    @if($callQuestionnaire->callScript)
                                        <a href="{{ route('call-scripts.show', $callQuestionnaire->callScript) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $callQuestionnaire->callScript->title }}
                                        </a>
                                    @else
                                        <span class="text-red-600">{{ __('Скрипт не найден') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Статус:') }}</p>
                                <p class="text-md font-medium">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $callQuestionnaire->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $callQuestionnaire->is_active ? 'Активна' : 'Неактивна' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Создана:') }}</p>
                                <p class="text-md">{{ $callQuestionnaire->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Последнее обновление:') }}</p>
                                <p class="text-md">{{ $callQuestionnaire->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($callQuestionnaire->callScript)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Скрипт обзвона') }}</h3>
                        <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-wrap mb-2">{{ $callQuestionnaire->callScript->content }}</div>
                    </div>
                    @endif

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Вопросы анкеты') }}</h3>
                        @if(!$callQuestionnaire->questions || empty($callQuestionnaire->questions))
                            <div class="bg-yellow-50 p-4 rounded-lg text-yellow-800 mb-4">
                                {{ __('В анкете не определены вопросы') }}
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($callQuestionnaire->questions as $index => $question)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-md font-medium">{{ $index + 1 }}. {{ $question['text'] }}</p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ __('Тип:') }} 
                                                    @if($question['type'] === 'text')
                                                        {{ __('Текстовый ответ') }}
                                                    @elseif($question['type'] === 'radio')
                                                        {{ __('Один вариант (radio)') }}
                                                    @elseif($question['type'] === 'checkbox')
                                                        {{ __('Несколько вариантов (checkbox)') }}
                                                    @elseif($question['type'] === 'select')
                                                        {{ __('Выпадающий список (select)') }}
                                                    @endif
                                                    
                                                    @if(isset($question['required']) && $question['required'])
                                                        <span class="ml-2 text-red-600">{{ __('Обязательный') }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if(in_array($question['type'], ['radio', 'checkbox', 'select']) && isset($question['options']) && !empty($question['options']))
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600">{{ __('Варианты ответа:') }}</p>
                                                <ul class="list-disc list-inside ml-2 mt-1">
                                                    @foreach($question['options'] as $option)
                                                        <li class="text-sm">{{ $option }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @can('read call_response')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Ответы на анкету') }}</h3>
                        @can('create call_response')
                        <a href="{{ route('call-responses.fill', $callQuestionnaire) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Заполнить анкету') }}
                        </a>
                        @endcan
                    </div>
                    
                    @if($callQuestionnaire->responses->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-gray-500">{{ __('Нет ответов на эту анкету') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Дата') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Оператор') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Заявка') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Статус') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Действия') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($callQuestionnaire->responses as $response)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $response->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $response->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $response->user->name ?? __('Неизвестно') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($response->clientRequest)
                                                    <a href="{{ route('requests.show', $response->clientRequest) }}" class="text-blue-600 hover:text-blue-900">
                                                        #{{ $response->clientRequest->id }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">{{ __('Нет') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($response->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($response->status === 'partial') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    @if($response->status === 'completed')
                                                        {{ __('Завершён') }}
                                                    @elseif($response->status === 'partial')
                                                        {{ __('Частично') }}
                                                    @else
                                                        {{ __('Не удалось') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('call-responses.show', $response) }}" class="text-blue-600 hover:text-blue-900">
                                                        {{ __('Просмотр') }}
                                                    </a>
                                                    
                                                    @can('delete call_response')
                                                    <form method="POST" action="{{ route('call-responses.destroy', $response) }}" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Вы уверены, что хотите удалить этот ответ?') }}')">
                                                            {{ __('Удалить') }}
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout> 