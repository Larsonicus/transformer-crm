<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Statistics Button -->
                <div class="shrink-0 flex items-center ml-4">
                    <a href="http://transformer-crm/statistics" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Статистика
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @can('read request')
                    <x-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')" wire:navigate>
                        {{ __('Заявки') }}
                    </x-nav-link>
                    @endcan

                    @can('read user')
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" wire:navigate>
                        {{ __('Пользователи') }}
                    </x-nav-link>
                    @endcan

                    @can('read partner')
                    <x-nav-link :href="route('partners.index')" :active="request()->routeIs('partners.*')" wire:navigate>
                        {{ __('Партнеры') }}
                    </x-nav-link>
                    @endcan

                    @can('read source')
                    <x-nav-link :href="route('sources.index')" :active="request()->routeIs('sources.*')" wire:navigate>
                        {{ __('Источники') }}
                    </x-nav-link>
                    @endcan

                    @can('read task')
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" wire:navigate>
                        {{ __('Задачи') }}
                    </x-nav-link>
                    @endcan
                    
                    @can('read call_script')
                    <x-nav-link :href="route('call-scripts.index')" :active="request()->routeIs('call-scripts.*')" wire:navigate>
                        {{ __('Скрипты обзвона') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @can('read request')
            <x-responsive-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')" wire:navigate>
                {{ __('Заявки') }}
            </x-responsive-nav-link>
            @endcan

            @can('read user')
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" wire:navigate>
                {{ __('Пользователи') }}
            </x-responsive-nav-link>
            @endcan

            @can('read partner')
            <x-responsive-nav-link :href="route('partners.index')" :active="request()->routeIs('partners.*')" wire:navigate>
                {{ __('Партнеры') }}
            </x-responsive-nav-link>
            @endcan

            @can('read source')
            <x-responsive-nav-link :href="route('sources.index')" :active="request()->routeIs('sources.*')" wire:navigate>
                {{ __('Источники') }}
            </x-responsive-nav-link>
            @endcan

            @can('read task')
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" wire:navigate>
                {{ __('Задачи') }}
            </x-responsive-nav-link>
            @endcan
            
            @can('read call_script')
            <x-responsive-nav-link :href="route('call-scripts.index')" :active="request()->routeIs('call-scripts.*')" wire:navigate>
                {{ __('Скрипты обзвона') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
