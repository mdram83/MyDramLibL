<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($itemable->getItemableType()) . ' ' . __('Details')}}
        </h2>
    </x-slot>

        @php ( $componentName = lcfirst((new ReflectionClass($itemable::class))->getShortName()) . '.show-content' )
        <x-itemable.main>
            <x-dynamic-component
                :component="$componentName"
                :itemable="$itemable"/>
        </x-itemable.main>

</x-app-layout>
