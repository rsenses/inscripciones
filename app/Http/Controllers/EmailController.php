<?php

namespace App\Http\Controllers;

use App\Models\Product;

class EmailController extends Controller
{
    public function claim(Product $product)
    {
        $checkouts = $product->checkouts()
            ->where(function ($q) {
                $q->where('checkouts.status', 'accepted');
                $q->orWhere('checkouts.status', 'pending');
            })
            ->distinct()
            ->get();

        foreach ($checkouts as $checkout) {
            $checkout->resendLastEmail();
        }

        return redirect()->route('products.show', [
            'product' => $product
        ]);
    }
}
