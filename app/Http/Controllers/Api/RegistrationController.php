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
            '*.user_id' => ['required', 'exists:users,id'],
            '*.product_id' => [
                'required',
                'exists:products,id',
                new MaxRegistrations($request),
            ],
            '*.promo' => 'nullable|string'
        ]);

        $response = [];
        $amount = 0;
        $firstAction = null;

        $checkout = Checkout::create([
            'user_id' => $request->all()[0]['user_id'],
            'amount' => $request->promo ? 0.00 : $amount,
            'token' => uniqid()
        ]);

        $response['checkout'] = $checkout;

        foreach ($request->all() as $registrationAttempt) {
            $product = Product::find($registrationAttempt['product_id']);
            $user = User::find($registrationAttempt['user_id']);

            $amount = $amount + $product->price;

            $checkout->products()->attach($registrationAttempt['product_id']);

            $registration = $user->registrations()->create([
                'product_id' => $registrationAttempt['product_id'],
                'checkout_id' => $checkout->id,
                'promo' => $registrationAttempt['promo'],
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
        }

        CheckoutCreated::dispatch($checkout);

        return response()->json($response);
    }
}
