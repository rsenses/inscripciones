<?php

namespace App\Rules;

use App\Http\Controllers\DealController;
use App\Models\Deal;
use App\Models\Discount as ModelsDiscount;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class Discount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $product_id, int $checkout_id)
    {
        $this->product_id = $product_id;
        $this->checkout_id = $checkout_id;
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
        $discount = ModelsDiscount::where('code', $value)
            ->where('product_id', $this->product_id)
            ->where(function($q) {
                $q->whereNull('due_at');
                $q->orWhere('due_at', '>=', Carbon::now());
            })
            ->count();

        $deal = Deal::where('checkout_id', $this->checkout_id)->first();

        return $discount && !$deal;
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
