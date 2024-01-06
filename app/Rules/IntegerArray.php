<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IntegerArray implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // validate that User_ids are only integer values
        $integerOnly = collect($value)->every(fn ($element) => is_int($element));
        //dump($integerOnly);

        if (! $integerOnly) {
            $fail($attribute . ' can only be integers.');
        }
    }
}
