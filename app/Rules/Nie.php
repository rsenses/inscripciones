<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Nie implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $original = strtoupper($value);

        if (preg_match('/([XYZ]\d{7,8}[A-Z])/', $original)) {
            $nie = (int) str_replace(['X', 'Y', 'Z'], [0, 1, 2], substr($original, 0, -1));

            $portion = $nie % 23;

            $letter = substr("TRWAGMYFPDXBNJZSQVHLCKE", $portion, 1);

            return $letter == substr($original, -1);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Documento de identidad no válido';
    }
}
