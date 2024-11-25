<?php

namespace App\Rules;

use App\Services\Constant\Cake\CakeIngredientUnit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUnit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! array_key_exists($value, CakeIngredientUnit::OPTION)) {
            $fail("The $attribute is invalid.");
        }
    }
}
