@props(['value' => null])

<x-itemable.form.label for="volumes" value="Volumes"/>
<x-itemable.form.input type="number"
                       id="volumes"
                       name="volumes"
                       value="{{ old('volumes') ?? $value }}"
                       placeholder="and no. of volumes"
                       min="1"
                       max="9999"
/>
<x-itemable.form.error name="volumes"/>
