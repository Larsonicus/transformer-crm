<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">{{ $request->title }}</h2>
            <span class="px-2 py-1 text-xs rounded-full
                @switch($request->status)
                    @case('new') bg-blue-100 text-blue-800 @break
                    @case('in_progress') bg-yellow-100 text-yellow-800 @break
                    @case('completed') bg-green-100 text-green-800 @break
                @endswitch">
                {{ $request->status }}
            </span>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-600">Описание:</label>
                <p class="mt-1">{{ $request->description }}</p>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Пользователь:</label>
                    <p class="mt-1">{{ $request->user->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Партнёр:</label>
                    <p class="mt-1">{{ $request->partner->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Источник:</label>
                    <p class="mt-1">{{ $request->source->name }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('requests.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </div>
    </div>
</div>
