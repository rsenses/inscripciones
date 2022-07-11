<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TpvController extends Controller
{
    public function notify(Request $request, Checkout $checkout)
    {
        $response = $checkout->gateway();

        if ($response->isSuccessful()) {
            $checkout->update(['method' => 'card']);
                
            $checkout->pay();
        } else {
            Log::debug($response->getMessage());
            $checkout->tpv = $response->getMessage();
            $checkout->save();

            $checkout->regenerateId();
        }
    }

    public function return(Request $request, Checkout $checkout)
    {
        $template = 'payments.success';

        if ($request->method && $request->method === 'transfer') {
            $checkout->apply('hang');
        } else {
            $response = $checkout->gateway();

            if ($response->isSuccessful()) {
                if ($checkout->status === 'processing') {
                    $checkout->pay();
                }
            } else {
                if ($checkout->status === 'disabled') {
                    $checkout = Checkout::where('user_id', $checkout->user_id)
                    ->where('status', '!=', 'disabled')
                    ->where('token', $checkout->token)
                    ->first();
                } else {
                    $checkout = $checkout->new();
                }

                $template = 'payments.error';
            }
        }

        if (!$checkout) {
            $checkout = $checkout->regenerateId();
        }

        return view($template, [
            'checkout' => $checkout,
            'products' => $checkout->productsArray(),
        ]);
    }
}
