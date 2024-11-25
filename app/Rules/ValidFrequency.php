<?php

namespace App\Rules;

use App\Services\Constant\Setting\FrequencyConstant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFrequency implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! array_key_exists($value, FrequencyConstant::OPTION)) {
            $fail("The $attribute is invalid.");
        }
    }
}
