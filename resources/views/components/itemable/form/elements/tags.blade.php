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
                                  'itemable',
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
    formId="itemable"
    hiddenInputName="tags[]"
/>

@if(isset($tags) && $tags->count() > 0)
    <x-itemable.form.provide-hidden
        prefix="tag"
        divId="selectedTags"
        formId="itemable"
        hiddenInputName="tags[]"
        :values="$tags"
    />
@endif
