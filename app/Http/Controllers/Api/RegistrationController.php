<?php

namespace App\Http\Controllers\Api;

use App\Notifications\CheckoutCreated;
use App\Events\CheckoutCreated as CheckoutCreatedEvent;
use App\Models\Product;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MaxRegistrations;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::with(['registrations' => function ($query) {
            $query->where('status', 'paid');
        }, 'registrations.user'])
            ->findOrFail($product->id);

        return $product;
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
            'user_id' => ['required', 'exists:users,id'],
            'products' => ['required', 'array'],
            'products.*' => [
                'required',
                'exists:products,id',
                new MaxRegistrations($request),
            ],
            'promo' => 'nullable|string'
        ]);

        $response = [];
        $amount = 0;
        $firstAction = null;

        $checkout = Checkout::create([
            'user_id' => $request->user_id,
            'amount' => $request->promo ? 0.00 : $amount,
            'token' => uniqid()
        ]);

        foreach ($request->products as $productId) {
            $product = Product::find($productId);
            $user = User::find($request->user_id);

            $amount = $amount + $product->price;

            $registration = $user->registrations()->create([
                'product_id' => $productId,
                'checkout_id' => $checkout->id,
                'promo' => $request->promo,
                'metadata' => $request->all()
            ]);

            if (!$firstAction) {
                $firstAction = $registration->product->first_action;
            }
            
            $response['registrations'][] = $registration;
        }

        $checkout->update([
            'amount' => $amount
        ]);

        $checkout->applyAutomaticDiscount();

        $checkout = $checkout->fresh();

        if ($firstAction) {
            $checkout->apply($firstAction);
            $checkout->save();
        } else {
            CheckoutCreatedEvent::dispatch($checkout);
            
            $checkout->user->notify(new CheckoutCreated($checkout));
        }

        $response['checkout'] = $checkout;

        return response()->json($response);
    }
}
