<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Registration;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partner = Partner::current()->first();

        $products = $partner->products()
            ->orderByRaw('(CASE WHEN `products`.`start_date` > CURDATE() THEN `products`.`start_date` end) ASC, (CASE WHEN `products`.`start_date` < CURDATE() THEN `products`.`start_date` end) DESC')
            ->get();

        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create', [
            'campaigns' => Campaign::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'url' => 'required|active_url',
            'description' => 'nullable',
            'price' => 'nullable|numeric|min:0',
            'mode' => 'required|in:presencial,online',
            'place' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'campaign_id' => ['required', 'exists:campaigns,id']
        ]);

        $product = Product::create($request->except('_token'));

        return redirect()->route('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $registrations = Registration::where('product_id', $product->id)
            ->latest()
            ->whereHas('checkout', function (Builder $query) {
                $query->where('amount', '>=', 0);
            })
            ->get();

        return view('products.show', [
            'product' => $product,
            'registrations' => $registrations
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'campaigns' => Campaign::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'url' => 'required|active_url',
            'description' => 'nullable',
            'price' => 'nullable|numeric|min:0',
            'mode' => 'required|in:presencial,online',
            'place' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'campaign_id' => ['required', 'exists:campaigns,id']
        ]);

        $product->update($request->except('_token'));

        return redirect()->route('products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
