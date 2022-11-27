@props(['value' => null])

<input type="hidden"
       id="thumbnail"
       name="thumbnail"
       value="{{ old('thumbnail') ?? $value}}"
/>
