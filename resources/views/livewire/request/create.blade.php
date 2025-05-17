<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-6">Создание новой заявки</h2>

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <!-- Название -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Название</label>
                    <input type="text" wire:model="title"
                           class="mt-1 block w-full rounded border-gray-300 @error('title') border-red-500 @enderror">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Описание -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Описание</label>
                    <textarea wire:model="description" rows="4"
                              class="mt-1 block w-full rounded border-gray-300 @error('description') border-red-500 @enderror"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Выпадающие списки -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Пользователь -->
                    @if($canManageUsers)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Пользователь</label>
                        <select wire:model="user_id" class="mt-1 block w-full rounded border-gray-300 @error('user_id') border-red-500 @enderror">
                            <option value="">Выберите пользователя</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <!-- Партнер -->
                    @if($canManagePartners && !auth()->user()->hasRole('partner'))
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Партнер</label>
                        <select wire:model="partner_id" class="mt-1 block w-full rounded border-gray-300 @error('partner_id') border-red-500 @enderror">
                            <option value="">Выберите партнера</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                        @error('partner_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <!-- Источник -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Источник</label>
                        <select wire:model="source_id" class="mt-1 block w-full rounded border-gray-300 @error('source_id') border-red-500 @enderror">
                            <option value="">Выберите источник</option>
                            @foreach($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        </select>
                        @error('source_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Статус -->
                @if(auth()->user()->can('update request'))
                <div>
                    <label class="block text-sm font-medium text-gray-700">Статус</label>
                    <select wire:model="status" class="mt-1 block w-full rounded border-gray-300 @error('status') border-red-500 @enderror">
                        <option value="new">Новая</option>
                        <option value="in_progress">В работе</option>
                        <option value="completed">Завершена</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif

                <!-- Кнопки -->
                <div class="flex justify-end space-x-4 mt-6">
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
