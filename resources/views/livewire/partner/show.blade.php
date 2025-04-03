<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">{{ $partner->name }}</h2>
            <a href="{{ route('partners.edit', $partner) }}"
               class="text-blue-500 hover:text-blue-700">Редактировать</a>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-600">Контактный email:</label>
                <p class="mt-1">{{ $partner->contact_email }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-600">Телефон:</label>
                <p class="mt-1">{{ $partner->phone ?? '-' }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-600">Дата создания:</label>
                <p class="mt-1">{{ $partner->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('partners.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </div>
    </div>
</div>
