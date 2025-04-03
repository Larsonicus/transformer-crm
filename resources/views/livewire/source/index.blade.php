<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Источники</h1>
        <a href="{{ route('sources.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Добавить источник
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <div class="p-4 border-b border-gray-200">
            <input type="text" wire:model.lazy="search" placeholder="Поиск по названию..."
                   class="border rounded px-3 py-2 w-64">
            <select wire:model="perPage" class="border rounded px-3 py-2 ml-2">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата создания</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($sources as $source)
                <tr>
                    <td class="px-6 py-4">{{ $source->name }}</td>
                    <td class="px-6 py-4">{{ $source->created_at->format('d.m.Y H:i') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('sources.show', $source) }}"
                           class="text-blue-500 hover:text-blue-700">Просмотр</a>
                        <a href="{{ route('sources.edit', $source) }}"
                           class="text-green-500 hover:text-green-700">Редактировать</a>
                        <button wire:click="delete({{ $source->id }})"
                                onclick="return confirm('Удалить источник?')"
                                class="text-red-500 hover:text-red-700">Удалить</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $sources->links() }}
        </div>
    </div>
</div>
