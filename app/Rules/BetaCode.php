<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class BetaCode implements InvokableRule
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
        if ($value != config('auth.beta_code')) {
            $fail('Incorrect Beta Code');
        }
    }
}
