<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center">
            <div class="flex-auto items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __($itemable->getItemableType()) . ' ' . __('Details')}}
                </h2>
            </div>
            <div class="flex-auto items-center text-right">
                <x-library-button
                    class="-my-1"
                    onclick="location.href = '{{ request()->url() . '/edit' }}'"
                >Edit</x-library-button>
            </div>
        </div>


    </x-slot>

        @php ( $componentName = lcfirst((new ReflectionClass($itemable::class))->getShortName()) . '.show-content' )
        <x-itemable.main>
            <x-dynamic-component
                :component="$componentName"
                :itemable="$itemable"/>
        </x-itemable.main>

</x-app-layout>
