<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class EAN implements InvokableRule
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
        if (!$this->isValidEan($value)) {
            $fail('Provided :attribute is not a valid EAN number.');
        }
    }

    private function isValidEan(string $ean) : bool
    {
        if (!preg_match('/^[0-9]+$/', $ean)) {
            return false;
        }

        if (!in_array(strlen($ean), [8,12,13,14,17,18])) {
            return false;
        }

        $controlDigit = substr($ean, -1);
        $remainingDigits = substr($ean, 0, -1);
        $evenDigitsSum = $oddDigitsSum = 0;
        $isEven = true;

        while (strlen($remainingDigits) > 0) {
            $digit = (int) substr($remainingDigits, -1);
            if($isEven)
                $evenDigitsSum += 3 * $digit;
            else
                $oddDigitsSum += $digit;
            $isEven = !$isEven;
            $remainingDigits = substr($remainingDigits, 0, -1);
        }

        $sum = $evenDigitsSum + $oddDigitsSum;
        $sumRoundedUp = ceil($sum / 10) * 10;

        return ($controlDigit == ($sumRoundedUp - $sum));
    }
}
