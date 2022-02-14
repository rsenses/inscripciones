<?php

namespace App\Services;

use App\Models\Checkout;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;

class Discounts
{
    public static function iiCongreso(Checkout $checkout)
    {
        $products = $checkout->products->pluck('id')->toArray();

        $target = [10,11,12,13,14];

        $occurrences = array_count_values($products);
        $min = min(array_values($occurrences));
        $countIntersect = count(array_intersect($target, array_keys($occurrences)));

        if ($countIntersect == count($target)) {
            $discount = [
                'concept' => 'Descuento por compra de múltiples talleres',
                'amount' => 30 * $min,
            ];

            return $discount;
        }

        return false;
    }
}
