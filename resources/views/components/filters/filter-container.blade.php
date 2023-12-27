@props(['filterName'])

<div class="py-4 px-0 sm:px-2">
    <h2 class="font-semibold text-lg sm:mb-2 mb-0">{{ $filterName }}</h2>
    <div class="py-2">
        {{ $slot }}
    </div>
</div>
