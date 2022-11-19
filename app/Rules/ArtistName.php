<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class ArtistName implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (substr_count($value, ',') > 1 || str_starts_with($value, ',') || str_ends_with($value, ',')) {
            $fail(':attribute must not have coma in first or last name.');
        }

        // TODO below seems not working
        foreach (explode($value, ',') as $namePart) {
            if (mb_strlen($namePart) > 255) {
                $fail(':attribute first and last name must not exceed 255 characters.');
            }
        }
    }
}
