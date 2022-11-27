<x-itemable.form.form action="/books/{{ $itemable->id }}" patch>

    <!-- ISBN -->
    <x-itemable.form.elements.book.isbn value="{{ $itemable->isbn }}"/>

    <!-- Thumbnail -->
    <x-itemable.form.elements.thumbnail value="{{ $itemable->item->thumbnail }}"/>

    <!-- Title -->
    <x-itemable.form.elements.title value="{{ $itemable->item->title }}"/>

    <div class="grid grid-cols-4 sm:gap-2 gap-1">

        <div class="sm:col-span-2 col-span-full">
            <!-- Series -->
            <x-itemable.form.elements.book.series value="{{ $itemable->series }}"/>
        </div>

        <div class="sm:col-span-1 col-span-2">
            <!-- Volume -->
            <x-itemable.form.elements.book.volume value="{{ $itemable->volume }}"/>
        </div>

        <div class="sm:col-span-1 col-span-2">
            <!-- Pages -->
            <x-itemable.form.elements.book.pages value="{{ $itemable->pages }}"/>
        </div>

    </div>

    <!-- Publishing -->
    <x-itemable.form.elements.publishing
        publisherName="{{ $itemable->item->publisher?->name }}"
        publishedAt="{{ $itemable->item->published_at }}"
    />

    <!-- Tags -->
    <x-itemable.form.elements.tags :tags="$itemable->item->tags->map(fn($tag) => $tag->name)"/>

    <!-- Authors -->
    <x-itemable.form.elements.artists
        labelFor="authors"
        LabelValue="Authors"
        elementsPrefix="author"
        hiddenInputName="authors"
        buttonText="Add Author"
        :artists="$itemable->getAuthors()->map(fn($artist) => $artist->getName())"
    />

    <!-- Comment -->
    <x-itemable.form.elements.comment value="{{ $itemable->item->comment }}"/>

    <!-- Submit -->
    <div class="flex justify-center">
        <x-primary-button class="w-full justify-center">Update</x-primary-button>
    </div>

</x-itemable.form.form>
