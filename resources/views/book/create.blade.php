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

                <form id="create" method="POST" action="/books/store">
                    @csrf

                    @push('custom-scripts')
                        @vite('resources/js/library/ajax/generic-datalist.js')
                    @endpush

                    <!-- ISBN -->
                    @push('custom-scripts')
                        @vite('resources/js/library/ajax/isbn-details.js')
                    @endpush
                    <x-itemable.form.label for="isbn" class="mt-0">ISBN</x-itemable.form.label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text"
                                                   id="isbn"
                                                   name="isbn"
                                                   oninput="window.changeIsbnButtonStyle('enabled');"
                                                   placeholder="Enter ISBN..."
                            />
                        </div>
                        <div>
                            <x-primary-button type="button"
                                              id="isbn-button"
                                              class="w-full justify-center"
                                              onclick="window.ajaxGetDetailsWithISBN()"
                            >Get Details</x-primary-button>
                        </div>
                    </div>

                    <!-- Title -->
                    <x-itemable.form.label for="title">
                        Title&nbsp;<span class="text-red-700 font-bold">*</span>
                    </x-itemable.form.label>
                    <x-itemable.form.input type="text" id="title" name="title" placeholder="Enter Title..." required/>

                    <div class="grid grid-cols-4 sm:gap-2 gap-1">
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

                    <div class="grid grid-cols-4 sm:gap-2 gap-1">

                        <div class="sm:col-span-3 col-span-full">

                            <!-- Publisher -->
                            <x-itemable.form.label for="publisher">Publisher</x-itemable.form.label>
                            <x-itemable.form.input type="text"
                                                   id="publisher"
                                                   name="publisher"
                                                   list="publishers"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateGenericDatalist('publishers', 'name', '/ajax/publishers');"
                                                   placeholder="Enter Publisher..."/>
                            <datalist id="publishers"></datalist>
                        </div>

                        <div class="sm:col-span-1 col-span-full">

                            <!-- Published At -->
                            <x-itemable.form.label for="published_at">Published At</x-itemable.form.label>
                            <x-itemable.form.input type="number" id="published_at" name="published_at" placeholder="Enter Year of Publishing"
                                                   min="-4000" max="9999"
                            />

                        </div>
                    </div>

                    <!-- Tags -->
                    @push('custom-scripts')
                        @vite('resources/js/library/tags-operations.js')
                    @endpush
                    <x-itemable.form.label for="tag">Tags</x-itemable.form.label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text"
                                                   id="tag"
                                                   name="tag"
                                                   list="tags"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateGenericDatalist('tags', 'name', '/ajax/tags');"
                                                   placeholder="Enter Tags..."/>
                            <datalist id="tags"></datalist>
                        </div>
                        <div>
                            <x-primary-button type="button"
                                              class="w-full justify-center"
                                              onclick="window.addTagToSelection(document.getElementById('tag').value);"
                            >Add Tag</x-primary-button>
                        </div>
                        <div id="selectedTags" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>
                    </div>


                    <!-- Authors -->
                    @push('custom-scripts')
                        @vite('resources/js/library/ajax/artists-index.js')
                        @vite('resources/js/library/artists-operations.js')
                    @endpush
                    <x-itemable.form.label for="authors">Authors</x-itemable.form.label>
                    <div class="grid sm:grid-cols-8 grid-cols-2 gap-2">
                        <div class="sm:col-span-3 order-first">
                            <x-itemable.form.input type="text"
                                                   id="artistFirstname"
                                                   name="artistFirstname"
                                                   list="artistFirstnames"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateArtistsDatalist();"
                                                   placeholder="Author first name..."/>
                            <datalist id="artistFirstnames"></datalist>
                        </div>
                        <div class="sm:col-span-3 sm:order-none order-3">
                            <x-itemable.form.input type="text"
                                                   id="artistLastname"
                                                   name="artistLastname"
                                                   list="artistLastnames"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateArtistsDatalist();"
                                                   placeholder="Author last name..."/>
                            <datalist id="artistLastnames"></datalist>
                        </div>
                        <div class="sm:col-span-2 sm:order-none order-2 row-span-2">
                            <x-primary-button type="button"
                                              class="w-full justify-center sm:h-auto h-full"
                                              onclick="
                                                window.addArtistToSelection(
                                                    window.getArtistFromInputs('artistFirstname', 'artistLastname')
                                                );
                                              "
                            >Add Author</x-primary-button>
                        </div>
                        <div id="selectedArtists" class="col-span-full order-last text-sm text-white leading-6 flex flex-wrap"></div>
                    </div>

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
