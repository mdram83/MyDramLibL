@props(['value' => null])

<x-itemable.form.label for="duration" value="Duration"/>
<x-itemable.form.input type="time"
                       step="1"
                       id="duration"
                       name="duration"
                       min="00:00:00"
                       max="99:99:99"
                       value="{{ old('duration') ?? $value }}"
                       placeholder="Add duration"
/>
<x-itemable.form.error name="duration"/>
