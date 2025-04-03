<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-6">Создание новой заявки</h2>

        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <!-- Поля формы -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Название</label>
                    <input type="text" wire:model="title"
                           class="mt-1 block w-full rounded border-gray-300">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Описание</label>
                    <textarea wire:model="description" rows="4"
                              class="mt-1 block w-full rounded border-gray-300"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Выпадающие списки -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Пользователь</label>
                        <select wire:model="user_id" class="mt-1 block w-full rounded border-gray-300">
                            <option value="">Выберите пользователя</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Аналогично для partner и source -->
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Статус</label>
                    <select wire:model="status" class="mt-1 block w-full rounded border-gray-300">
                        @foreach(['new', 'in_progress', 'completed'] as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('requests.index') }}"
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Отмена
                    </a>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Сохранить
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
