<?php

namespace App\Http\Controllers;

use App\Models\Product;

class EmailController extends Controller
{
    public function claim(Product $product)
    {
        $registrations = $product->registrations()
            ->where('status', 'accepted')
            ->orWhere('status', 'pending')
            ->get();

        foreach ($registrations as $registration) {
            $registration->resendLastEmail();
        }

        return redirect()->route('products.show', [
            'product' => $product
        ]);
    }
}
