<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель управления источника') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Заявки -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Заявки от этого источника') }}</h3>
                    <div class="space-y-4">
                        @foreach($requests as $request)
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $request->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $request->created_at->format('d.m.Y H:i') }}</p>
                                        <p class="text-sm text-gray-600">Статус: {{ $request->status }}</p>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:text-blue-800">Подробнее</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 