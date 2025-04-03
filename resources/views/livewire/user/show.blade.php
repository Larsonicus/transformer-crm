<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
            <a href="{{ route('users.edit', $user) }}"
               class="text-blue-500 hover:text-blue-700">Редактировать</a>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-600">Email:</label>
                <p class="mt-1">{{ $user->email }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-600">Дата регистрации:</label>
                <p class="mt-1">{{ $user->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('users.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </div>
    </div>
</div>
