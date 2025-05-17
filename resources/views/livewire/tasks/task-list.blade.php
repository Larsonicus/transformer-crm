<div class="p-4" x-data>
    <!-- Notifications -->
    @if($successMessage)
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            {{ $successMessage }}
        </div>
    @endif

    @if($errorMessage)
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            {{ $errorMessage }}
        </div>
    @endif

    <!-- Status Columns -->
    <div class="flex gap-4">
        @foreach($statuses as $status => $statusName)
            <div class="flex-1 bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ $statusName }}</h3>
                    <span class="text-sm text-gray-500">
                        {{ isset($tasks[$status]) ? count($tasks[$status]) : 0 }} задач
                    </span>
                </div>
                
                <div class="task-list space-y-3 min-h-[200px] p-2 rounded-lg transition-colors duration-200" 
                     data-status="{{ $status }}">
                    @if(isset($tasks[$status]))
                        @foreach($tasks[$status] as $task)
                            <div class="task-item bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 cursor-move border border-gray-100 transform hover:scale-[1.02] active:scale-[1.01]" 
                                 data-task-id="{{ $task->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-2">
                                        @if($task->priority === 'high')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Высокий
                                            </span>
                                        @endif
                                        @if($task->due_date)
                                            <span class="text-sm text-gray-500 whitespace-nowrap">
                                                {{ $task->due_date->format('d.m.Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($task->description, 100) }}</p>
                                
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        @if($task->assignedUser)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $task->assignedUser->name }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($task->partner)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-50 text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $task->partner->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
// Проверяем, загружен ли Sortable
if (typeof Sortable === 'undefined') {
    // Если Sortable не загружен, загружаем его
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
    script.onload = initializeSortable;
    document.head.appendChild(script);
} else {
    initializeSortable();
}

function initializeSortable() {
    const lists = document.querySelectorAll('.task-list');
    
    lists.forEach(list => {
        new Sortable(list, {
            group: 'tasks',
            handle: '.task-item',
            animation: 150,
            ghostClass: 'opacity-50',
            dragClass: 'shadow-xl scale-105',
            chosenClass: 'bg-gray-100',
            scroll: true,
            scrollSensitivity: 80,
            scrollSpeed: 20,
            onStart: function (evt) {
                lists.forEach(list => {
                    list.classList.add('bg-blue-50');
                });
                evt.item.classList.add('rotating-cursor');
            },
            onEnd: function (evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.dataset.status;
                const order = evt.newIndex;
                
                lists.forEach(list => {
                    list.classList.remove('bg-blue-50');
                });
                evt.item.classList.remove('rotating-cursor');
                
                // Вызываем метод Livewire
                Livewire.find(evt.to.closest('[wire\\:id]').getAttribute('wire:id'))
                    .call('updateTaskStatus', taskId, newStatus, order);
            },
            onChange: function(evt) {
                const targetList = evt.to;
                targetList.classList.add('bg-blue-100');
                setTimeout(() => {
                    targetList.classList.remove('bg-blue-100');
                }, 200);
            }
        });
    });
}

// Стили для перетаскивания
const style = document.createElement('style');
style.textContent = `
    .task-item {
        cursor: grab;
        user-select: none;
        touch-action: none;
    }
    .task-item:active {
        cursor: grabbing;
    }
    .task-list {
        transition: background-color 0.2s ease;
    }
    .rotating-cursor {
        cursor: grabbing !important;
    }
`;
document.head.appendChild(style);

// Обработка обновления задач
window.addEventListener('task-updated', event => {
    const taskLists = document.querySelectorAll('.task-list');
    taskLists.forEach(list => {
        list.classList.add('bg-green-50');
        setTimeout(() => {
            list.classList.remove('bg-green-50');
        }, 300);
    });
});
</script>
@endpush 