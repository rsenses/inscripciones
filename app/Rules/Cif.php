<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cif implements Rule
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
        $cif = strtoupper($value);

        $cif_codes = 'JABCDEFGHI';

        if (ctype_alnum($cif)) {
            if (strlen($cif) === 9) {
                if (preg_match('/([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])/', $cif)) {
                    $sum = (string) $this->getCifSum($cif);
                    $n = (10 - substr($sum, -1)) % 10;

                    if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)) {
                        if (in_array($cif[0], array('A', 'B', 'E', 'H'))) {
                            // Numerico
                            return ($cif[8] == $n);
                        } elseif (in_array($cif[0], array('K', 'P', 'Q', 'S'))) {
                            // Letras
                            return ($cif[8] == $cif_codes[$n]);
                        } else {
                            // Alfanumérico
                            if (is_numeric($cif[8])) {
                                return ($cif[8] == $n);
                            } else {
                                return ($cif[8] == $cif_codes[$n]);
                            }
                        }
                    }
                }
            }
        }

        return false;
    }

    private function getCifSum($cif)
    {
        $sum = (int) $cif[2] + (int) $cif[4] + (int) $cif[6];

        for ($i = 1; $i<8; $i += 2) {
            $tmp = (string) (2 * $cif[$i]);

            $tmp = $tmp[0] + ((strlen($tmp) == 2) ?  $tmp[1] : 0);

            $sum += $tmp;
        }

        return $sum;
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
