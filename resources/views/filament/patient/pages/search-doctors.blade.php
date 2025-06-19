<x-filament::page>
    @vite('resources/css/app.css')
    <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-end">
        <flux:input
            wire:model.debounce.300ms="search"
            placeholder="Search doctors..."
            class="flex-1"
        />
        <div>
            <select wire:model="sort" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <option value="name">Sort by Name</option>
                <option value="email">Sort by Email</option>
            </select>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($this->doctors as $doctor)
            <x-doctor-card :doctor="$doctor" wire:key="$doctor->id">
                @if ($this->hasRequested($doctor))
                    <span class="text-sm text-gray-500">Requested</span>
                @else
                    <flux:button wire:click="requestFollow({{ $doctor->id }})" size="sm">
                        Request Follow
                    </flux:button>
                @endif
            </x-doctor-card>
        @endforeach
    </div>
</x-filament::page>
