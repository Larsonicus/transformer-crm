<div>
    <button wire:click="logout" class="w-full px-4 py-2 text-left text-sm leading-5 text-red-600 hover:text-red-700 hover:bg-red-50 focus:outline-none focus:bg-red-50 transition duration-150 ease-in-out flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        {{ __('Выйти') }}
    </button>
</div> 