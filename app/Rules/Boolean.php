<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use function App\Helpers\to_boolean;

class Boolean implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void{
        if(!is_bool(to_boolean($value))){
            $fail(__('validation.boolean'));
        }
    }

}
