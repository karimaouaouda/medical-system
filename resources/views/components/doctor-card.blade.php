@props(['doctor'])
<div {{ $attributes->class('flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow border') }}>
    <img
        src="https://ui-avatars.com/api/?name={{ urlencode($doctor->name) }}"
        alt="{{ $doctor->name }}"
        class="h-12 w-12 rounded-full"
    />
    <div class="flex-1">
        <div class="font-semibold">{{ $doctor->name }}</div>
        <div class="text-sm text-gray-500">{{ $doctor->email }}</div>
    </div>
    {{ $slot }}
</div>
