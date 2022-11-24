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

                <form id="create" method="POST" action="/music/store">
                    @csrf

                    @push('custom-scripts')
                        @vite('resources/js/library/ajax/generic-datalist.js')
                        @vite('resources/js/library/form-hidden-operations.js')
                    @endpush

                    <!-- EAN -->
{{--                    @push('custom-scripts')--}}
{{--                        @vite('resources/js/library/ajax/isbn-details.js')--}}
{{--                    @endpush--}}
                    <x-itemable.form.label for="ean" value="EAN" class="mt-0"/>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text"
                                                   id="ean"
                                                   name="ean"
{{--                                                   oninput="window.changeIsbnButtonStyle('enabled');"--}}
                                                   value="{{ old('ean') }}"
                                                   placeholder="Start here..."
                            />
                        </div>
                        <div>
                            <x-primary-button type="button"
                                              id="ean-button"
                                              class="w-full justify-center"
{{--                                              onclick="window.ajaxGetDetailsWithISBN('create');"--}}
                            >Get Details</x-primary-button>
                        </div>
                    </div>
                    <x-itemable.form.error name="ean"/>

                    <!-- Thumbnail -->
                    <x-itemable.form.input type="url"
                                           id="thumbnail"
                                           name="thumbnail"
                                           value="{{ old('thumbnail') }}"
                                           readonly
                                           class="hidden"
                    />



                    <!-- Title -->
                    <x-itemable.form.label for="title">
                        Title <span class="text-red-700 font-bold">*</span>
                    </x-itemable.form.label>
                    <x-itemable.form.input type="text"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="Add title"
                                           required
                    />
                    <x-itemable.form.error name="title"/>

                    <div class="grid grid-cols-2 gap-1">
                        <div>

                            <!-- Duration -->
                            <x-itemable.form.label for="duration" value="Duration"/>
                            <x-itemable.form.input type="time"
                                                   step="1"
                                                   id="duration"
                                                   name="duration"
                                                   min="00:00:01" {{--TODO after testing change to 00:00:00--}}
                                                   max="99:99:99"
                                                   value="{{ old('duration') }}"
                                                   placeholder="Add duration"
                            />
                            <x-itemable.form.error name="duration"/>

                        </div>
                        <div>

                            <!-- Volumes -->
                            <x-itemable.form.label for="volumes" value="Volumes"/>
                            <x-itemable.form.input type="number"
                                                   id="volumes"
                                                   name="volumes"
                                                   value="{{ old('volumes') }}"
                                                   placeholder="and no. of volumes"
                                                   min="1"
                                                   max="9999"
                            />
                            <x-itemable.form.error name="volumes"/>

                        </div>

                    </div>

                    <div class="grid grid-cols-4 sm:gap-2 gap-1">

                        <div class="sm:col-span-3 col-span-full">

                            <!-- Publisher -->
                            <x-itemable.form.label for="publisher" value="Publisher"/>
                            <x-itemable.form.input type="text"
                                                   id="publisher"
                                                   name="publisher"
                                                   list="publishers"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateGenericDatalist('publishers', 'name', '/ajax/publishers');"
                                                   value="{{ old('publisher') }}"
                                                   placeholder="Select/add publisher"
                            />
                            <x-itemable.form.error name="publisher"/>
                            <datalist id="publishers"></datalist>
                        </div>

                        <div class="sm:col-span-1 col-span-full">

                            <!-- Published At -->
                            <x-itemable.form.label for="published_at" value="Published At"/>
                            <x-itemable.form.input type="number"
                                                   id="published_at"
                                                   name="published_at"
                                                   value="{{ old('published_at') }}"
                                                   placeholder="and published year"
                                                   min="1901"
                                                   max="2155"
                            />
                            <x-itemable.form.error name="published_at"/>
                        </div>
                    </div>

                    <!-- Tags -->
                    <x-itemable.form.label for="tag" value="Tags"/>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text"
                                                   id="tag"
                                                   name="tag"
                                                   list="tags"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateGenericDatalist('tags', 'name', '/ajax/tags');"
                                                   placeholder="Select/add tags"
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

                    <!-- Main Artists -->
                    @push('custom-scripts')
                        @vite('resources/js/library/ajax/artists-index.js')
                        @vite('resources/js/library/artists-operations.js')
{{--                        TODO Add similar for Main Bands (guilds-operations.js)--}}
                    @endpush
                    <x-itemable.form.label for="mainArtists" value="Main Artists"/>
                    <div class="grid sm:grid-cols-8 grid-cols-2 gap-2">
                        <div class="sm:col-span-3 order-first">
                            <x-itemable.form.input type="text"
                                                   id="artistFirstname"
                                                   name="artistFirstname"
                                                   list="artistFirstnames"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateArtistsDatalist();"
                                                   placeholder="Select/add first name"
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
                                                   placeholder="Select/add last name"
                            />
                            <datalist id="artistLastnames"></datalist>
                        </div>
                        <div class="sm:col-span-2 sm:order-none order-2 row-span-2">
                            <x-primary-button type="button"
                                              class="w-full justify-center sm:h-auto h-full"
                                              onclick="window.addToSelection(
                                                  window.getArtistFromInputs('artistFirstname', 'artistLastname'),
                                                  'mainArtists',
                                                  'selectedMainArtists',
                                                  'create',
                                                  'mainArtists[]',
                                                  'artistFirstname',
                                                  ['artistFirstname', 'artistLastname']
                                              );"
                            >Add Main Artist</x-primary-button>
                        </div>
                        <div id="selectedMainArtists" class="col-span-full order-last text-sm text-white leading-6 flex flex-wrap"></div>
                    </div>
                    <x-itemable.form.error-array name="mainArtists"/>
                    <x-itemable.form.restore-hidden
                        httpName="mainArtists"
                        prefix="mainArtists"
                        divId="selectedMainArtists"
                        formId="create"
                        hiddenInputName="mainArtists[]"
                    />

                    <!-- Main Bands -->
                    <x-itemable.form.label for="mainBand" value="Main Bands"/>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-itemable.form.input type="text"
                                                   id="mainBand"
                                                   name="mainBand"
                                                   list="bands"
                                                   autocomplete="off"
                                                   onfocus="window.ajaxPopulateGenericDatalist('bands', 'name', '/ajax/guilds');"
                                                   placeholder="Select/add tags"
                            />
                            <datalist id="bands"></datalist>
                        </div>
                        <div>
                            <x-primary-button type="button"
                                              class="w-full justify-center"
                                              onclick="window.addToSelection(
                                                  document.getElementById('mainBand').value,
                                                  'mainBands',
                                                  'selectedMainBands',
                                                  'create',
                                                  'mainBands[]',
                                                  'mainBand',
                                                  ['mainBand']
                                              );"
                            >Add Main Band</x-primary-button>
                        </div>
                        <div id="selectedMainBands" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>
                    </div>
                    <x-itemable.form.error-array name="mainBands" class=""/>
                    <x-itemable.form.restore-hidden
                        httpName="mainBands"
                        prefix="mainBands"
                        divId="selectedMainBands"
                        formId="create"
                        hiddenInputName="mainBands[]"
                    />

                    <!-- Comment -->
                    <x-itemable.form.label for="comment" value="Comment"/>
                    <x-itemable.form.textarea id="comment"
                                              name="comment"
                                              placeholder="Your comments"
                                              rows="3"
                    >{{ old('comment') }}</x-itemable.form.textarea>
                    <x-itemable.form.error name="comment" class="mt-0.5 mb-4"/>

                    <!-- Submit -->
                    <div class="flex justify-center">
                        <x-primary-button class="w-full justify-center">Add</x-primary-button>
                    </div>

                </form>

            </div>
        </div>

    </x-main-row>

</x-app-layout>
