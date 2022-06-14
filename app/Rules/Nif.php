<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Nif implements Rule
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

        if (ctype_alnum($original)) {
            if (strlen($original) === 9) {
                if (preg_match('/(\d{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1})/', $original)) {
                    $dni = (int) substr($original, 0, -1);

                    $portion = $dni % 23;

                    $letter = substr("TRWAGMYFPDXBNJZSQVHLCKE", $portion, 1);

                    return $letter == substr($original, -1);
                }
            }
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
