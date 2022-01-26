<?php

namespace App\Http\Controllers\Api;

use App\Events\CheckoutAccepted;
use App\Models\Product;
use App\Models\Registration;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
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
                'promo' => $request->promo,
                'metadata' => $request->all()
            ]);

            if (!$firstAction) {
                $firstAction = $registration->product->first_action;
            }

            if ($registration->product->first_action) {
                $registration->{$registration->product->first_action}();
            }
            
            $response['registrations'][] = $registration;
        }

        $checkout->update([
            'amount' => $amount
        ]);

        if ($firstAction === 'accept') {
            $checkout->update([
                'status' => 'accepted'
            ]);
            CheckoutAccepted::dispatch($checkout);
        }

        return response()->json($response);
    }
}
