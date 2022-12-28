<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex
        items-center
        px-2
        py-1
        border border-transparent
        rounded-md
        font-semibold
        text-xs
        text-white
        tracking-widest
        focus:outline-none
        disabled:opacity-25
        transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
