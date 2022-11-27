@props(['value' => null])

<x-itemable.form.label for="series" value="Series"/>
<x-itemable.form.input type="text"
                       id="series"
                       name="series"
                       value="{{ old('series') ?? $value }}"
                       placeholder="Add series"
/>
<x-itemable.form.error name="series"/>
