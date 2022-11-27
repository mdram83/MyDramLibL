<x-itemable.form.form action="/music/store">

    <!-- EAN -->
    <x-itemable.form.elements.musicAlbum.ean/>

    <!-- Thumbnail -->
    <x-itemable.form.elements.thumbnail/>

    <!-- Title -->
    <x-itemable.form.elements.title/>

    <div class="grid grid-cols-2 gap-1">

        <div>
            <!-- Duration -->
            <x-itemable.form.elements.musicAlbum.duration/>
        </div>

        <div>
            <!-- Volumes -->
            <x-itemable.form.elements.musicAlbum.volumes/>
        </div>

    </div>

    <!-- Publishing -->
    <x-itemable.form.elements.publishing/>

    <!-- Tags -->
    <x-itemable.form.elements.tags/>

    <!-- Main Artists -->
    <x-itemable.form.elements.artists
        labelFor="mainArtists"
        LabelValue="Main Artists"
        elementsPrefix="mainArtist"
        hiddenInputName="mainArtists"
        buttonText="Add Main Artist"
    />

    <!-- Main Bands -->
    <x-itemable.form.elements.guilds
        labelFor="mainBands"
        labelValue="Main Bands"
        elementsPrefix="mainBand"
        hiddenInputName="mainBands"
        buttonText="Add Main Band"
    />

    <!-- Comment -->
    <x-itemable.form.elements.comment/>

    <!-- Submit -->
    <div class="flex justify-center">
        <x-primary-button class="w-full justify-center">Add</x-primary-button>
    </div>

</x-itemable.form.form>
