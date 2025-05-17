<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель управления администратора') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Статистика -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Заявки</h3>
                        <p class="text-2xl font-semibold">{{ $stats['total_requests'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Пользователи</h3>
                        <p class="text-2xl font-semibold">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Партнеры</h3>
                        <p class="text-2xl font-semibold">{{ $stats['total_partners'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Источники</h3>
                        <p class="text-2xl font-semibold">{{ $stats['total_sources'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500">Задачи</h3>
                        <p class="text-2xl font-semibold">{{ $stats['total_tasks'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Последние заявки -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ __('Последние заявки') }}</h3>
                            <a href="{{ route('requests.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Все заявки</a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recent_requests as $request)
                                <div class="border-b pb-4">
                                    <h4 class="font-medium">{{ $request->title }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $request->created_at ? $request->created_at->format('d.m.Y H:i') : 'Дата не указана' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Последние пользователи -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ __('Последние пользователи') }}</h3>
                            <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Все пользователи</a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recent_users as $user)
                                <div class="border-b pb-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium">{{ $user->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        </div>
                                        <div class="ml-4">
                                            <select 
                                                class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                onchange="updateUserRole(this, {{ $user->id }})"
                                            >
                                                <option value="">Выберите роль</option>
                                                @foreach($all_roles as $role)
                                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Последние задачи -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ __('Последние задачи') }}</h3>
                            <a href="{{ route('task-list') }}" class="text-sm text-blue-600 hover:text-blue-800">Все задачи</a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recent_tasks as $task)
                                <div class="border-b pb-4">
                                    <h4 class="font-medium">{{ $task->title }}</h4>
                                    <p class="text-sm text-gray-600">
                                        Срок: {{ $task->due_date ? $task->due_date->format('d.m.Y') : 'Не указан' }}
                                    </p>
                                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                                        @if($task->status === 'completed') bg-green-100 text-green-800
                                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $task->status }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateUserRole(selectElement, userId) {
            const role = selectElement.value;
            if (!role) return;

            fetch(`/admin/users/${userId}/update-role`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ role: role })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Показываем уведомление об успехе
                    alert(data.message);
                } else {
                    // Показываем сообщение об ошибке
                    alert('Произошла ошибка при обновлении роли');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при обновлении роли');
            });
        }
    </script>
    @endpush
</x-app-layout> 