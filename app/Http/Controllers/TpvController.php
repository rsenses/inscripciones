<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TpvController extends Controller
{
    public function notify(Request $request, Checkout $checkout)
    {
        $response = $checkout->gatewayResponse();

        Log::debug($response->isSuccessful());
        Log::debug($response->getMessage());

        if ($response->isSuccessful()) {
            $checkout->apply('pay');
            $checkout->save();
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
            $response = $checkout->gatewayResponse();

            try {
                if ($response->isSuccessful()) {
                    if ($checkout->status === 'processing') {
                        $checkout->apply('pay');
                    }
                } else {
                    if ($checkout->status === 'disabled') {
                        $checkout = Checkout::where('user_id', $checkout->user_id)
                        ->where('status', '!=', 'disabled')
                        ->where('token', $checkout->token)
                        ->first();
                    } else {
                        $checkout = $checkout->regenerateId();
                    }

                    $template = 'payments.error';
                }
            } catch (\Exception $e) {
                Log::debug($e->getMessage());
                // internal error, log exception and display a generic message to the customer
                exit('Sorry, there was an error processing your payment. Please try again later.');
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
