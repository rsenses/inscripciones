<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Product;

class MaxRegistrations implements Rule
{
    public $request;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
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
        foreach ($this->request as $registrationAttempt) {
            $product = Product::findOrFail($registrationAttempt['product_id']);

            $registrationCount = Registration::where('product_id', $product->id)
                ->where('user_id', $registrationAttempt['user_id'])
                ->count();
            
            if ($registrationCount >= $product->max_quantity && $product->max_quantity > 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No se puede registrar dos veces al mismo evento.';
    }
}
