<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ошибка') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Произошла ошибка') }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        {{ __('При загрузке панели управления произошла ошибка. Пожалуйста, попробуйте позже.') }}
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            {{ __('Попробовать снова') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 