<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- PLACEHOLDER FOR QUICK LINKS -->

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @foreach($items as $item)
                        {{ $item->id }}
                        {{ \App\Utilities\Librarian\Navigator::getItemableShowLink($item) }}
                    @endforeach

                    <p>Welcome in Library. When done, you will see most important information on this page like
                        summary of your items, the latest items added by your friends, the latest discussion topics or else.</p>
                    <p class="pt-4">For now please go to available options from menu to view and add your items.</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
