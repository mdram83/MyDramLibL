<x-itemable.form.form action="/books">

    <!-- ISBN -->
    <x-itemable.form.elements.book.isbn/>

    <!-- Thumbnail -->
    <x-itemable.form.elements.thumbnail/>

    <!-- Title -->
    <x-itemable.form.elements.title/>

    <div class="grid grid-cols-4 sm:gap-2 gap-1">

        <div class="sm:col-span-2 col-span-full">
            <!-- Series -->
            <x-itemable.form.elements.book.series/>
        </div>

        <div class="sm:col-span-1 col-span-2">
            <!-- Volume -->
            <x-itemable.form.elements.book.volume/>
        </div>

        <div class="sm:col-span-1 col-span-2">
            <!-- Pages -->
            <x-itemable.form.elements.book.pages/>
        </div>

    </div>

    <!-- Publishing -->
    <x-itemable.form.elements.publishing/>

    <!-- Tags -->
    <x-itemable.form.elements.tags/>

    <!-- Authors -->
    <x-itemable.form.elements.artists
        labelFor="authors"
        LabelValue="Authors"
        elementsPrefix="author"
        hiddenInputName="authors"
        buttonText="Add Author"
    />

    <!-- Comment -->
    <x-itemable.form.elements.comment/>

    <!-- Submit -->
    <div class="flex justify-center">
        <x-primary-button class="w-full justify-center">Add</x-primary-button>
    </div>

</x-itemable.form.form>
