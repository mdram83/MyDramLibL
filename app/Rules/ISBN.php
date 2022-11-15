<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class ISBN implements InvokableRule
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
        if (!$this->isValidISBN($value)) {
            $fail('The :attribute is not valid ISBN number.');
        }
    }

    private function isValidISBN(string $isbn): bool
    {
        $isbn = str_replace('-', '', $isbn);
        if (!(preg_match('/^(\d{9}(\d|X))$/', $isbn) || preg_match('/^(\d){13}$/', $isbn))) {
            return false;
        }
        return $this->{'checkSumISBN' . strlen($isbn)}($isbn);
    }

    private function checkSumISBN10(string $isbn): bool
    {
        $stringArray = str_split($isbn);
        for ($i = 1, $sum = 0; $i < 10; $i++) {
            $sum += (int) $stringArray[$i - 1] * $i;
        }
        return ($sum % 11 == str_replace('X', '10', $stringArray[9]));
    }

    private function checkSumISBN13(string $isbn): bool
    {
        $stringArray = str_split($isbn);
        for ($i = 1, $sum = 0; $i < 13; $i++) {
            $sum += (int) $stringArray[$i - 1] * (($i % 2 == 0) ? 3 : 1);
        }
        return ((($sum % 10 == 0) ? 0 : (10 - $sum % 10)) == $stringArray[12]);
    }
}
