@props(['disabled' => false, 'required' => false, 'value'])

<textarea
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    {!! $attributes->merge([
    'class' => '
        w-full
        text-sm
        rounded-sm
        shadow-sm
        border-gray-300
        focus:border-indigo-300
        focus:ring
        focus:ring-indigo-200
        focus:ring-opacity-50
    '
]) !!}>{{ $value ?? $slot }}</textarea>
