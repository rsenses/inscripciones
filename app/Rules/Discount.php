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
        foreach ($this->checkout->products as $product) {
            $discount = DiscountModel::where('code', $value)
                ->where('product_id', $product->id)
                ->where(function ($q) {
                    $q->whereNull('due_at');
                    $q->orWhere('due_at', '>=', Carbon::now());
                })
                ->first();

            $deal = Deal::where('checkout_id', $this->checkout->id)->first();

            $count = true;
            if ($discount && $discount->uses != 0) {
                $dealsCount = Deal::where('discount_id', $discount->id)->count();

                if ($dealsCount >= $discount->uses) {
                    $count = false;
                }
            }

            return $discount && !$deal && $count;
        }
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
