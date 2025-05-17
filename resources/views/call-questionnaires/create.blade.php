<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Создание анкеты обзвона') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('call-questionnaires.store') }}" id="questionnaireForm">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Название анкеты')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="call_script_id" :value="__('Скрипт обзвона')" />
                            <select id="call_script_id" name="call_script_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Выберите скрипт') }}</option>
                                @foreach($scripts as $script)
                                <option value="{{ $script->id }}" {{ old('call_script_id') == $script->id ? 'selected' : '' }}>
                                    {{ $script->title }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('call_script_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <x-input-label for="is_active" :value="__('Активна')" />
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="ml-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Вопросы анкеты') }}</h3>
                            <div id="questions-container">
                                <!-- Здесь будут добавляться вопросы -->
                            </div>
                            <div class="mt-2">
                                <button type="button" id="add-question-btn" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('Добавить вопрос') }}
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('call-questionnaires.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Отмена') }}
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Сохранить анкету') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Шаблон для нового вопроса -->
    <template id="question-template">
        <div class="question-item bg-gray-50 p-4 rounded-lg mb-4">
            <input type="hidden" name="questions[{index}][id]" value="{id}">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-9">
                    <x-input-label :value="__('Текст вопроса')" />
                    <x-text-input class="block mt-1 w-full" type="text" name="questions[{index}][text]" required />
                </div>
                <div class="md:col-span-3">
                    <x-input-label :value="__('Тип вопроса')" />
                    <select name="questions[{index}][type]" class="question-type block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="text">{{ __('Текст') }}</option>
                        <option value="radio">{{ __('Один вариант (radio)') }}</option>
                        <option value="checkbox">{{ __('Несколько вариантов (checkbox)') }}</option>
                        <option value="select">{{ __('Выпадающий список (select)') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="options-container mt-4 hidden">
                <x-input-label :value="__('Варианты ответа')" />
                <div class="options-list mb-2">
                    <div class="option-item flex items-center space-x-2 mb-2">
                        <x-text-input class="w-full" type="text" name="questions[{index}][options][]" placeholder="Вариант ответа" />
                        <button type="button" class="remove-option text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="button" class="add-option inline-flex items-center px-2 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Добавить вариант') }}
                </button>
            </div>
            
            <div class="flex items-center mt-4">
                <input type="checkbox" name="questions[{index}][required]" value="1" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-600">{{ __('Обязательный вопрос') }}</span>
                
                <button type="button" class="remove-question ml-auto inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    {{ __('Удалить вопрос') }}
                </button>
            </div>
        </div>
    </template>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionCount = 0;
            const questionsContainer = document.getElementById('questions-container');
            const addQuestionBtn = document.getElementById('add-question-btn');
            const questionTemplate = document.getElementById('question-template');
            
            // Добавление вопроса
            addQuestionBtn.addEventListener('click', function() {
                addQuestion();
            });
            
            // Функция добавления вопроса
            function addQuestion(questionData = null) {
                const index = questionCount++;
                let questionHtml = questionTemplate.innerHTML
                    .replace(/{index}/g, index)
                    .replace(/{id}/g, questionData?.id || '');
                
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = questionHtml;
                const questionElement = tempDiv.firstElementChild;
                
                // Заполняем данные, если они переданы
                if (questionData) {
                    questionElement.querySelector('input[name="questions[' + index + '][text]"]').value = questionData.text;
                    questionElement.querySelector('select[name="questions[' + index + '][type]"]').value = questionData.type;
                    if (questionData.required) {
                        questionElement.querySelector('input[name="questions[' + index + '][required]"]').checked = true;
                    } else {
                        questionElement.querySelector('input[name="questions[' + index + '][required]"]').checked = false;
                    }
                    
                    // Показываем опции для соответствующих типов вопросов
                    if (['radio', 'checkbox', 'select'].includes(questionData.type)) {
                        const optionsContainer = questionElement.querySelector('.options-container');
                        optionsContainer.classList.remove('hidden');
                        
                        // Удаляем шаблонный вариант ответа
                        const optionsList = optionsContainer.querySelector('.options-list');
                        optionsList.innerHTML = '';
                        
                        // Добавляем варианты ответов
                        if (questionData.options && questionData.options.length) {
                            questionData.options.forEach(option => {
                                addOption(optionsList, index, option);
                            });
                        } else {
                            addOption(optionsList, index);
                        }
                    }
                }
                
                questionsContainer.appendChild(questionElement);
                
                // Обработчики событий для нового вопроса
                const questionTypeSelect = questionElement.querySelector('.question-type');
                questionTypeSelect.addEventListener('change', function() {
                    const optionsContainer = this.closest('.question-item').querySelector('.options-container');
                    if (['radio', 'checkbox', 'select'].includes(this.value)) {
                        optionsContainer.classList.remove('hidden');
                        
                        // Проверяем, есть ли уже варианты ответов
                        const optionsList = optionsContainer.querySelector('.options-list');
                        if (optionsList.children.length === 0) {
                            addOption(optionsList, index);
                        }
                    } else {
                        optionsContainer.classList.add('hidden');
                    }
                });
                
                // Обработчик для добавления нового варианта ответа
                const addOptionBtn = questionElement.querySelector('.add-option');
                addOptionBtn.addEventListener('click', function() {
                    const optionsList = this.closest('.options-container').querySelector('.options-list');
                    addOption(optionsList, index);
                });
                
                // Обработчик для удаления вопроса
                const removeQuestionBtn = questionElement.querySelector('.remove-question');
                removeQuestionBtn.addEventListener('click', function() {
                    this.closest('.question-item').remove();
                });
                
                // Делегирование события для кнопки удаления варианта ответа
                questionElement.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-option')) {
                        const optionItem = e.target.closest('.option-item');
                        // Проверяем, чтобы оставался хотя бы один вариант
                        const optionsList = optionItem.closest('.options-list');
                        if (optionsList.children.length > 1) {
                            optionItem.remove();
                        } else {
                            alert('Необходимо оставить хотя бы один вариант ответа');
                        }
                    }
                });
            }
            
            // Функция добавления варианта ответа
            function addOption(optionsList, questionIndex, optionValue = '') {
                const optionHtml = `
                    <div class="option-item flex items-center space-x-2 mb-2">
                        <x-text-input class="w-full" type="text" name="questions[${questionIndex}][options][]" placeholder="Вариант ответа" value="${optionValue}" />
                        <button type="button" class="remove-option text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = optionHtml;
                optionsList.appendChild(tempDiv.firstElementChild);
            }
            
            // Добавляем первый вопрос при загрузке страницы
            addQuestion();
            
            // Обработка существующих вопросов
            @if(old('questions'))
                const oldQuestions = @json(old('questions'));
                // Очищаем контейнер от шаблонного вопроса
                questionsContainer.innerHTML = '';
                
                // Добавляем сохраненные вопросы
                oldQuestions.forEach(question => {
                    addQuestion(question);
                });
            @endif
        });
    </script>
    @endpush
</x-app-layout> 