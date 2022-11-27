<x-itemable.form.form action="/music/{{ $itemable->id }}" patch>

    <!-- EAN -->
    <x-itemable.form.elements.musicAlbum.ean value="{{ $itemable->ean }}"/>

    <!-- Thumbnail -->
    <x-itemable.form.elements.thumbnail value="{{ $itemable->item->thumbnail }}"/>

    <!-- Title -->
    <x-itemable.form.elements.title value="{{ $itemable->item->title }}"/>

    <div class="grid grid-cols-2 gap-1">

        <div>
            <!-- Duration -->
            <x-itemable.form.elements.musicAlbum.duration value="{{ $itemable->duration }}"/>
        </div>

        <div>
            <!-- Volumes -->
            <x-itemable.form.elements.musicAlbum.volumes value="{{ $itemable->volumes }}"/>
        </div>

    </div>

    <!-- Publishing -->
    <x-itemable.form.elements.publishing
        publisherName="{{ $itemable->item->publisher?->name }}"
        publishedAt="{{ $itemable->item->published_at }}"
    />

    <!-- Tags -->
    <x-itemable.form.elements.tags :tags="$itemable->item->tags->map(fn($tag) => $tag->name)"/>

    <!-- Main Artists -->
    <x-itemable.form.elements.artists
        labelFor="mainArtists"
        LabelValue="Main Artists"
        elementsPrefix="mainArtist"
        hiddenInputName="mainArtists"
        buttonText="Add Main Artist"
        :artists="$itemable->getMainArtists()->map(fn($artist) => $artist->getName())"
    />

    <!-- Main Bands -->
    <x-itemable.form.elements.guilds
        labelFor="mainBands"
        labelValue="Main Bands"
        elementsPrefix="mainBand"
        hiddenInputName="mainBands"
        buttonText="Add Main Band"
        :guilds="$itemable->getMainBands()->map(fn($guild) => $guild->name)"
    />

    <!-- Comment -->
    <x-itemable.form.elements.comment value="{{ $itemable->item->comment }}"/>

    <!-- Submit -->
    <div class="flex justify-center">
        <x-primary-button class="w-full justify-center">Update</x-primary-button>
    </div>

</x-itemable.form.form>
