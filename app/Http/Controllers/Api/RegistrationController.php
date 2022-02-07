<?php

namespace App\Http\Controllers\Api;

use App\Events\CheckoutAccepted;
use App\Events\CheckoutCreated;
use App\Models\Product;
use App\Models\Registration;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use App\Rules\MaxRegistrations;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
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

        $response['checkout'] = $checkout;

        foreach ($request->products as $productId) {
            $product = Product::find($productId);
            $user = User::find($request->user_id);

            $amount = $amount + $product->price;

            $checkout->products()->attach($productId);

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

        if ($firstAction) {
            $checkout->$firstAction();
        } else {
            CheckoutCreated::dispatch($checkout);
        }

        return response()->json($response);
    }
}
