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
use App\Models\Campaign;
use App\Http\Resources\RegistrationCollection;

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
        $registrations = $product->registrations()->with('user')->whereIn('status', ['paid', 'verified'])->get();

        return new RegistrationCollection($registrations);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function campaign(Request $request, Campaign $campaign)
    {
        $request->validate([
            'mode' => 'required|in:online,presencial'
        ]);

        $registrations = Registration::with('user', 'product')
            ->whereIn('status', ['paid', 'verified'])
            ->where(function ($q) use ($campaign, $request) {
                $q->whereHas('product', function ($q) use ($campaign, $request) {
                    return $q->where('campaign_id', $campaign->id)
                    ->where('mode', $request->mode);
                });
            })
            ->get();

        return new RegistrationCollection($registrations);
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
