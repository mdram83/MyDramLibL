@props(['value' => null])

<x-itemable.form.label for="comment" value="Comment"/>

<x-itemable.form.textarea
    id="comment" name="comment" placeholder="Your comments" rows="3"
>{{ old('comment') ?? $value}}</x-itemable.form.textarea>

<x-itemable.form.error name="comment" class="mt-0.5 mb-4"/>
