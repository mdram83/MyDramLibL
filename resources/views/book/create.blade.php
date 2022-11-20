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
                        @vite('resources/js/library/form-hidden-operations.js')
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
                                                   value="{{ old('isbn') }}"
                                                   placeholder="Enter ISBN..."
                            />
                        </div>
                        <div>
                            <x-primary-button type="button"
                                              id="isbn-button"
                                              class="w-full justify-center"
                                              onclick="window.ajaxGetDetailsWithISBN();"
                            >Get Details</x-primary-button>
                        </div>
                    </div>
                    <x-itemable.form.error name="isbn"/>

                    <!-- Title -->
                    <x-itemable.form.label for="title">
                        Title&nbsp;<span class="text-red-700 font-bold">*</span>
                    </x-itemable.form.label>
                    <x-itemable.form.input type="text"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="Enter Title..."
                                           required
                    />
                    <x-itemable.form.error name="title"/>

                    <div class="grid grid-cols-4 sm:gap-2 gap-1">
                        <div class="sm:col-span-2 col-span-full">

                            <!-- Series -->
                            <x-itemable.form.label for="series">Series</x-itemable.form.label>
                            <x-itemable.form.input type="text"
                                                   id="series"
                                                   name="series"
                                                   value="{{ old('series') }}"
                                                   placeholder="Enter Series..."
                            />
                            <x-itemable.form.error name="series"/>

                        </div>
                        <div class="sm:col-span-1 col-span-2">

                            <!-- Volume -->
                            <x-itemable.form.label for="volume">Volume</x-itemable.form.label>
                            <x-itemable.form.input type="number"
                                                   id="volume"
                                                   name="volume"
                                                   value="{{ old('volume') }}"
                                                   placeholder="Enter Volume Number..."
                                                   min="1"
                                                   max="9999"
                            />
                            <x-itemable.form.error name="volume"/>

                        </div>
                        <div class="sm:col-span-1 col-span-2">

                            <!-- Pages -->
                            <x-itemable.form.label for="pages">Pages</x-itemable.form.label>
                            <x-itemable.form.input type="number"
                                                   id="pages"
                                                   name="pages"
                                                   value="{{ old('pages') }}"
                                                   placeholder="Enter Number of Pages..."
                                                   min="1"
                                                   max="9999"
                            />
                            <x-itemable.form.error name="pages"/>

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
                                                   value="{{ old('publisher') }}"
                                                   placeholder="Enter Publisher..."
                            />
                            <x-itemable.form.error name="publisher"/>
                            <datalist id="publishers"></datalist>
                        </div>

                        <div class="sm:col-span-1 col-span-full">

                            <!-- Published At -->
                            <x-itemable.form.label for="published_at">Published At</x-itemable.form.label>
                            <x-itemable.form.input type="number"
                                                   id="published_at"
                                                   name="published_at"
                                                   value="{{ old('published_at') }}"
                                                   placeholder="Enter Year of Publishing"
                                                   min="1901"
                                                   max="2155"
                            />
                            <x-itemable.form.error name="published_at"/>
                        </div>
                    </div>

                    <!-- Tags -->
                    <x-itemable.form.label for="tag">Tags</x-itemable.form.label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text"
                                                   id="tag"
                                                   name="tag"
                                                   list="tags"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateGenericDatalist('tags', 'name', '/ajax/tags');"
                                                   placeholder="Enter Tags..."
                            />
                            <datalist id="tags"></datalist>
                        </div>
                        <div>
                            <x-primary-button type="button"
                                              class="w-full justify-center"
                                              onclick="window.addToSelection(
                                                  document.getElementById('tag').value,
                                                  'tag',
                                                  'selectedTags',
                                                  'create',
                                                  'tags[]',
                                                  'tag',
                                                  ['tag']
                                              );"
                            >Add Tag</x-primary-button>
                        </div>
                        <div id="selectedTags" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>
                    </div>
                    <x-itemable.form.error-array name="tags" class=""/>
                    <x-itemable.form.restore-hidden
                        httpName="tags"
                        prefix="tag"
                        divId="selectedTags"
                        formId="create"
                        hiddenInputName="tags[]"
                    />

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
                                                   placeholder="Author first name..."
                            />
                            <datalist id="artistFirstnames"></datalist>
                        </div>
                        <div class="sm:col-span-3 sm:order-none order-3">
                            <x-itemable.form.input type="text"
                                                   id="artistLastname"
                                                   name="artistLastname"
                                                   list="artistLastnames"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateArtistsDatalist();"
                                                   placeholder="Author last name..."
                            />
                            <datalist id="artistLastnames"></datalist>
                        </div>
                        <div class="sm:col-span-2 sm:order-none order-2 row-span-2">
                            <x-primary-button type="button"
                                              class="w-full justify-center sm:h-auto h-full"
                                              onclick="window.addToSelection(
                                                  window.getArtistFromInputs('artistFirstname', 'artistLastname'),
                                                  'artist',
                                                  'selectedArtists',
                                                  'create',
                                                  'authors[]',
                                                  'artistFirstname',
                                                  ['artistFirstname', 'artistLastname']
                                              );"
                            >Add Author</x-primary-button>
                        </div>
                        <div id="selectedArtists" class="col-span-full order-last text-sm text-white leading-6 flex flex-wrap"></div>
                    </div>
                    <x-itemable.form.error-array name="authors"/>
                    <x-itemable.form.restore-hidden
                        httpName="authors"
                        prefix="artist"
                        divId="selectedArtists"
                        formId="create"
                        hiddenInputName="authors[]"
                    />

                    <!-- Comment -->
                    <x-itemable.form.label for="comment">Comment</x-itemable.form.label>
                    <x-itemable.form.textarea id="comment"
                                              name="comment"
                                              placeholder="Your Comment..."
                                              rows="3"
                    >{{ old('comment') }}</x-itemable.form.textarea>
                    <x-itemable.form.error name="comment" class="mt-0.5 mb-4"/>

                    <!-- Submit -->
                    <div class="flex justify-center">
                        <x-primary-button class="w-full justify-center">Add</x-primary-button>
                    </div>
                    <x-itemable.form.error name="save" class="mt-0.5 mb-4"/>

                </form>

            </div>
        </div>

    </x-main-row>

</x-app-layout>
