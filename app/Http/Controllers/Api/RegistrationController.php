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
use App\Models\Campaign;

class RegistrationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
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
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function campaign(Campaign $campaign)
    {
        $registrations = Registration::with('user', 'product')
            ->where('status', 'paid')
            ->where(function ($q) use ($campaign) {
                $q->whereHas('product', function ($q) use ($campaign) {
                    return $q->where('campaign_id', $campaign->id);
                });
            })
            ->get();

        return $registrations;
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

        $response['checkout'] = $checkout;

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

        if ($firstAction) {
            $checkout->$firstAction();
        } else {
            CheckoutCreated::dispatch($checkout);
        }

        return response()->json($response);
    }
}
