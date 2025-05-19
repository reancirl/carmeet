<?php 

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsZipCode implements Rule
{
    public function passes($attribute, $value): bool
    {
        // 5 digits, optional - and 4 digits
        return (bool) preg_match('/^\d{5}(?:-\d{4})?$/', $value);
    }

    public function message(): string
    {
        return 'The :attribute must be a valid U.S. ZIP code (e.g. 12345 or 12345-6789).';
    }
}
