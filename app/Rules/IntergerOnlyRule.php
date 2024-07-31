<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IntergerOnlyRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $intergerOnly = collect($value)->every(fn ($element) => is_int($element));

        if (!$intergerOnly) {
            $fail($attribute . ' can only be integer');
        }
    }
}
