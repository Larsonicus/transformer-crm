<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Доступ ограничен') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H8m4-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('У вас не назначена роль в системе') }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        {{ __('Для доступа к панели управления необходимо, чтобы администратор назначил вам соответствующую роль.') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ __('Пожалуйста, обратитесь к администратору системы.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 