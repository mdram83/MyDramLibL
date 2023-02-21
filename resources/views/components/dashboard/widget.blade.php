@props(['title'])

<div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="ml-2">

        <div class="text-lg leading-7 font-semibold">{{ $title }}</div>

        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
            {{ $slot }}
        </div>

    </div>
</div>
