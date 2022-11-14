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

    <x-main-row>

        <div class="w-full flex justify-center">
            <div class="w-full max-w-2xl">

                <form method="POST" action="/books/store">
                    @csrf

                    <!-- ISBN -->
                    <x-itemable.form.label for="isbn" class="mt-0">ISBN</x-itemable.form.label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text" id="isbn" name="isbn" placeholder="Enter ISBN..."/>
                        </div>
                        <div>
                            <x-primary-button type="button" class="w-full justify-center">
                                Get Details
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Title -->
                    <x-itemable.form.label for="title">
                        Title&nbsp;<span class="text-red-700 font-bold">*</span>
                    </x-itemable.form.label>
                    <x-itemable.form.input type="text" id="title" name="title" placeholder="Enter Title..." required/>

                    <div class="grid grid-cols-4 gap-2">
                        <div class="sm:col-span-2 col-span-full">
                            <!-- Series -->
                            <x-itemable.form.label for="series">Series</x-itemable.form.label>
                            <x-itemable.form.input type="text" id="series" name="series" placeholder="Enter Series..."/>
                        </div>
                        <div class="sm:col-span-1 col-span-2">
                            <!-- Volume -->
                            <x-itemable.form.label for="volume">Volume</x-itemable.form.label>
                            <x-itemable.form.input type="number" id="volume" name="volume" placeholder="Enter Volume Number..."
                                                   min="1" max="99999"
                            />
                        </div>
                        <div class="sm:col-span-1 col-span-2">
                            <!-- Pages -->
                            <x-itemable.form.label for="pages">Pages</x-itemable.form.label>
                            <x-itemable.form.input type="number" id="pages" name="pages" placeholder="Enter Number of Pages..."
                                                   min="1" max="99999"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-2">

                        <div class="sm:col-span-3 col-span-full">

                            <!-- Publisher -->
                            @push('custom-scripts')
                                @vite('resources/js/library/ajax/publishers-index.js')
                            @endpush
                            <x-itemable.form.label for="publisher">Publisher</x-itemable.form.label>
                            <x-itemable.form.input type="text"
                                                   id="publisher"
                                                   name="publisher"
                                                   list="publishers"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulatePublishersDatalist();"
                                                   placeholder="Enter Publisher..."/>
                            <datalist id="publishers"></datalist>
                        </div>

                        <div class="sm:col-span-1 col-span-full">

                            <!-- Published At -->
                            <x-itemable.form.label for="published_at">Published At</x-itemable.form.label>
                            <x-itemable.form.input type="number" id="published_at" name="published_at" placeholder="Enter Year of Publishing"
                                                   min="-4000" max="99999"
                            />
                        </div>
                    </div>

                    <!-- Tags -->
                    <x-itemable.form.label for="tags">Tags</x-itemable.form.label>
                    TBD

                    <!-- Authors -->
                    <x-itemable.form.label for="authors">Authors</x-itemable.form.label>
                    TBD

                    <!-- Comment -->
                    <x-itemable.form.label for="comment">Comment</x-itemable.form.label>
                    <x-itemable.form.textarea
                        id="comment" name="comment" placeholder="Your Comment..." rows="3"
                    ></x-itemable.form.textarea>

                    <!-- Submit -->
                    <div class="flex justify-center">
                        <x-primary-button class="w-full justify-center">Add</x-primary-button>
                    </div>

                </form>

            </div>
        </div>

    </x-main-row>

</x-app-layout>
