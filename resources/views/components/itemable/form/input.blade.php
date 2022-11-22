@props(['disabled' => false, 'required' => false, 'readonly' => false, 'checked' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $checked ? 'checked' : '' }}
    {!! $attributes->merge([
    'class' => '
        w-full
        py-1.5
        text-sm
        rounded-sm
        shadow-sm
        border-gray-300
        focus:border-indigo-300
        focus:ring
        focus:ring-indigo-200
        focus:ring-opacity-50
    '
]) !!}>
