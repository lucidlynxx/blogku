@props(['action'])
<div @class([ 'flex items-center justify-center min-h-screen bg-gray-100 text-gray-900 filament-breezy-auth-component filament-login-page'
    , 'dark:bg-gray-900 dark:text-white'=> config('filament.dark_mode'),
    ])>

    <div class="w-screen max-w-md px-6 space-y-8 md:mt-0 md:px-2">
        <form wire:submit.prevent="{{ $action }}"
            @class([ 'p-8 space-y-8 bg-white/50 border border-gray-200 shadow-2xl rounded-2xl relative filament-breezy-auth-card'
            , 'dark:bg-gray-900/50 dark:border-gray-700'=> config('filament.dark_mode'),
            ])>
            {{ $slot }}
        </form>

        {{ $this->modal }}
        <x-filament::footer />
    </div>

    @livewire('notifications')

</div>