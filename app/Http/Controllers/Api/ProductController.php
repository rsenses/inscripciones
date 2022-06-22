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
    public function index(Request $request)
    {
        $request->validate([
            'campaign_id' => 'nullable|exists:campaigns,id',
            'mode' => 'nullable|in:online,presencial'
        ]);

        return Product::where(function ($q) use ($request) {
            if ($request->mode) {
                $q->where('mode', $request->mode);
            }
            if ($request->campaign_id) {
                $q->where('campaign_id', $request->campaign_id);
            }
        })
        ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }
}
