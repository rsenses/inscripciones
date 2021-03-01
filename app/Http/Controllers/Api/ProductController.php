<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::with(['registrations' => function($query) {
            $query->where('status', 'paid');
        }, 'registrations.user'])
            ->find($product->id);

        return $product;
    }
}
