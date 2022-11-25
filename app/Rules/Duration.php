<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Duration implements InvokableRule
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
        if (!$this->isValidDuration($value)) {
            $fail(':attribute should be in HH:mm:ss format.');
        }
    }

    private function isValidDuration(string $duration) : bool
    {
        if (!preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $duration)) {
            return false;
        }
        return true;
    }
}
