<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Просмотр скрипта обзвона') }}
            </h2>
            <div class="flex space-x-2">
                @can('update call_script')
                <a href="{{ route('call-scripts.edit', $callScript) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Редактировать') }}
                </a>
                @endcan
                <a href="{{ route('call-scripts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Информация о скрипте') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Название:') }}</p>
                                <p class="text-md font-medium">{{ $callScript->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Статус:') }}</p>
                                <p class="text-md font-medium">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $callScript->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $callScript->is_active ? 'Активен' : 'Неактивен' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Создан:') }}</p>
                                <p class="text-md">{{ $callScript->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Последнее обновление:') }}</p>
                                <p class="text-md">{{ $callScript->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                            @if($callScript->creator)
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Создатель:') }}</p>
                                <p class="text-md">{{ $callScript->creator->name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Текст скрипта') }}</h3>
                        <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-wrap">{{ $callScript->content }}</div>
                    </div>
                </div>
            </div>

            <!-- Связанные анкеты -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Анкеты для этого скрипта') }}</h3>
                        @can('create call_questionnaire')
                        <a href="{{ route('call-questionnaires.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Создать анкету') }}
                        </a>
                        @endcan
                    </div>

                    @if($callScript->questionnaires->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-gray-500">{{ __('Нет связанных анкет') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Название') }}
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
                                    @foreach($callScript->questionnaires as $questionnaire)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $questionnaire->title }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $questionnaire->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $questionnaire->is_active ? 'Активна' : 'Неактивна' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('call-questionnaires.show', $questionnaire) }}" class="text-blue-600 hover:text-blue-900">
                                                        {{ __('Просмотр') }}
                                                    </a>
                                                    @can('create call_response')
                                                    <a href="{{ route('call-responses.fill', $questionnaire) }}" class="text-green-600 hover:text-green-900">
                                                        {{ __('Заполнить') }}
                                                    </a>
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
        </div>
    </div>
</x-app-layout> 