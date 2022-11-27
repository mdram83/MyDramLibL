@props(['value' => null])

<x-itemable.form.label for="title">
    Title <span class="text-red-700 font-bold">*</span>
</x-itemable.form.label>
<x-itemable.form.input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') ?? $value }}"
                       placeholder="Add title"
                       required
/>
<x-itemable.form.error name="title"/>
