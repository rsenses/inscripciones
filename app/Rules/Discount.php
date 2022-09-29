<?php

namespace App\Rules;

use App\Models\Checkout;
use App\Models\Deal;
use App\Models\Discount as DiscountModel;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class Discount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
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
        $discount = DiscountModel::where('code', $value)
            ->first();

        if ($discount && $discount->applicable($this->checkout)) {
            return true;
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
        return 'Código de descuento no válido';
    }
}
