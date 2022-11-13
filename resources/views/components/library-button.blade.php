<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex
        items-center
        px-2
        py-1
        bg-blue-500
        border border-transparent
        rounded-md
        font-semibold
        text-xs
        text-white
        tracking-widest
        hover:bg-blue-400
        active:bg-blue-600
        focus:outline-none
        focus:border-blue-600
        focus:ring ring-blue-300
        disabled:opacity-25
        transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
