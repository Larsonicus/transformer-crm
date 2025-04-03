<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-6">Редактирование пользователя</h2>

        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Имя</label>
                    <input type="text" wire:model="user.name"
                           class="mt-1 block w-full rounded border-gray-300">
                    @error('user.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="user.email"
                           class="mt-1 block w-full rounded border-gray-300">
                    @error('user.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Новый пароль</label>
                    <input type="password" wire:model="password"
                           class="mt-1 block w-full rounded border-gray-300">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Подтверждение пароля</label>
                    <input type="password" wire:model="password_confirmation"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('users.index') }}"
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
