@props(['filterName'])

<div class="py-4 px-0 sm:px-2">
    <h3 class="font-semibold text-base">{{ $filterName }}</h3>
    <div class="py-2">
        {{ $slot }}
    </div>
</div>
