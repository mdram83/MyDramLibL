@props(['value'])

<label {{ $attributes->merge(['class' => '
    block
    w-full
    py-0.5
    mt-3
    font-medium
    font-semibold
    text-sm
    text-black
']) }}>
    {{ $value ?? $slot }}
</label>
