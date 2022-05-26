<?php

namespace App\Services;

use App\Models\Checkout;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class Discounts
{
    public static function iiCongreso(Checkout $checkout)
    {
        $discount = [];

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
        }

        $congressCount = $checkout->products()->where('products.id', 7)->count();

        if ($congressCount > 1 && $congressCount < 25) {
            $amount = 20 * $congressCount;

            if (!empty($discount)) {
                $amount = $amount + $discount['amount'];
            }

            $discount = [
                'concept' => 'Descuento por compra múltiple de Congreso',
                'amount' => $amount,
            ];
        } elseif ($congressCount >= 25) {
            $amount = 40 * $congressCount;

            if (!empty($discount)) {
                $amount = $amount + $discount['amount'];
            }

            $discount = [
                'concept' => 'Descuento por compra múltiple de Congreso',
                'amount' => $amount,
            ];
        }

        if (!empty($discount)) {
            return $discount;
        }

        return false;
    }

    public static function jornadaCF(Checkout $checkout)
    {
        $discount = false;

        $products = $checkout->products()->whereIn('products.id', [19, 21])->count();

        if ($products >= 1) {
            $preSale = Carbon::createFromFormat('m/d/Y H:i:s', '06/01/2022 23:59:59');
            $today = Carbon::now();

            if ($products >= 3) {
                $discount = [
                    'concept' => 'Descuento por compra múltiple',
                    'amount' => (10 / 100) * $checkout->amount,
                ];
            }

            if ($today <= $preSale) {
                $discount = [
                    'concept' => 'Descuento por compra anticipada',
                    'amount' => (35 / 100) * $checkout->amount,
                ];
            }

            if ($products >= 3 && $today <= $preSale) {
                $discount = [
                    'concept' => 'Descuento por compra anticipada',
                    'amount' => (45 / 100) * $checkout->amount,
                ];
            }
        }

        return $discount;
    }
}
