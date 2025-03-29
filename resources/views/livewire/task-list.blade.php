@inject('taskHelper', 'App\Helpers\TaskHelper')

<div class="task-list">
    <div class="flex space-x-4">
        @foreach($statuses as $status)
            <div class="task-column p-4 border rounded-lg w-1/3">
                <h3 class="text-xl text-center font-semibold">{{ $taskHelper->readableStatus($status) }}</h3>

                <ul>
                    @forelse($groupedTasks[$status->value] ?? [] as $task)
                        <li class="task-item my-2">
                            <div class="task-card p-2 border rounded">
                                <h4 class="text-lg">{{ $task->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $task->description }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-gray-500">Нет задач в этом статусе.</li>
                    @endforelse
                </ul>
            </div>
        @endforeach
    </div>
</div>
