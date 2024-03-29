<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Deal;
use App\Models\Discount as ModelsDiscount;
use App\Rules\Discount;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $checkout_id)
    {
        $checkout = Checkout::findOrFail($checkout_id);

        $request->validate([
            'code' => ['alpha_num', new Discount($checkout), 'required'],
        ]);

        $discount = ModelsDiscount::where('code', $request->code)->firstOrFail();

        $discount->apply($checkout);

        $checkout = $checkout->fresh();

        if ($checkout->amount === 0) {
            return redirect(route('tpv.success', ['checkout' => $checkout]));
        } else {
            if ($discount->type === 'fixed') {
                $value = 'de '.$discount->value.'€';
            } else {
                $value = 'del '.$discount->value.'%';
            }
            return redirect()->back()
                ->with('message', "Descuento $value aplicado correctamente")
                ->with('discount', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function show(Deal $deal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function edit(Deal $deal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deal $deal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {
        //
    }
}
