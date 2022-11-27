@props(['value' => null])

<x-itemable.form.label for="volume" value="Volume"/>
<x-itemable.form.input type="number"
                       id="volume"
                       name="volume"
                       value="{{ old('volume') ?? $value }}"
                       placeholder="and volume no."
                       min="1"
                       max="9999"
/>
<x-itemable.form.error name="volume"/>
