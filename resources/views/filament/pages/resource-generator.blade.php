<x-filament-panels::page>
    @if (session('success'))
        <div class="w-full bg-primary-600 text-white p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="generateResource">
        {{ $this->form }}
            <div class="py-4">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-primary-600 dark:hover:bg-primary-500 dark:focus:ring-primary-500">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-o-document-plus"
                        wire:target="search"
                        class="h-6 w-6  text-white "
                    >
                    </x-filament::icon>
                    {{-- <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg> --}}
                    Generate Resource
                </button>
            </div>
    </form>
</x-filament-panels::page>