<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center">
            <div class="flex-auto items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __($header) }}
                </h2>
            </div>
        </div>

    </x-slot>

    <x-itemable.main-form>
        <x-dynamic-component
            :component="$componentName"/>
    </x-itemable.main-form>

</x-app-layout>
