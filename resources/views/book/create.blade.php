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

        <form method="POST" action="/books/store">
            @csrf

            <!-- ISBN -->
            <x-itemable.form.label for="isbn">ISBN</x-itemable.form.label>
            <x-itemable.form.input type="text" id="isbn" name="isbn" placeholder="Enter ISBN..."/>

            <!-- Title -->
            <x-itemable.form.label for="title">Title</x-itemable.form.label>
            <x-itemable.form.input type="text" id="title" name="title" placeholder="Enter Title..." required/>

            <!-- Authors -->

            <!-- Series -->
            <x-itemable.form.label for="series">Series</x-itemable.form.label>
            <x-itemable.form.input type="text" id="series" name="series" placeholder="Enter Series..."/>

            <!-- Volume -->
            <x-itemable.form.label for="volume">Volume</x-itemable.form.label>
            <x-itemable.form.input type="number" id="volume" name="volume" placeholder="Enter Volume Number..."
                                   min="1" max="99999"
            />

            <!-- Pages -->
            <x-itemable.form.label for="pages">Pages</x-itemable.form.label>
            <x-itemable.form.input type="number" id="pages" name="pages" placeholder="Enter Number of Pages..."
                                   min="1" max="99999"
            />

            <!-- Published At -->
            <x-itemable.form.label for="published_at">Published At</x-itemable.form.label>
            <x-itemable.form.input type="number" id="published_at" name="published_at" placeholder="Enter Year of Publishing"
                                   min="-4000" max="99999"
            />

            <!-- Publisher -->

            <!-- Tags -->

            <!-- Comment -->
            <x-itemable.form.label for="comment">Comment</x-itemable.form.label>
            <x-itemable.form.textarea
                id="comment" name="comment" placeholder="Your Comment..."
            ></x-itemable.form.textarea>

            <!-- Submit -->
            <x-primary-button>Save</x-primary-button>

        </form>

    </x-main-row>

</x-app-layout>
