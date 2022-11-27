@props(['value' => null])

<x-itemable.form.label for="pages" value="Pages"/>
<x-itemable.form.input type="number"
                       id="pages"
                       name="pages"
                       value="{{ old('pages') ?? $value }}"
                       placeholder="No. of pages"
                       min="1"
                       max="9999"
/>
<x-itemable.form.error name="pages"/>
