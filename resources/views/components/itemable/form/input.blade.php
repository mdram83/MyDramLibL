@props(['disabled' => false, 'required' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    {!! $attributes->merge([
    'class' => '
        rounded-md
        shadow-sm
        border-gray-300
        focus:border-indigo-300
        focus:ring
        focus:ring-indigo-200
        focus:ring-opacity-50
    '
]) !!}>
