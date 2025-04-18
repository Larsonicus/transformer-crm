<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-6">Редактирование источника</h2>

        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Название</label>
                    <input type="text" wire:model="source.name"
                           class="mt-1 block w-full rounded border-gray-300">
                    @error('source.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('sources.index') }}"
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
