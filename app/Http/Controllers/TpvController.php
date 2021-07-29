<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;
use Throwable;
use Illuminate\Support\Facades\Log;

class TpvController extends Controller
{
    public function notify(Request $request, Checkout $checkout)
    {
        Log::debug($request->all);
        try {
            $company = $checkout->product->partners[0];
            $key = $company->merchant_key;

            $redsys = new Tpv();

            $parameters = $redsys->getMerchantParameters($request->Ds_MerchantParameters);
            $DsResponse = $parameters['Ds_Response'];
            $DsResponse += 0;

            if ($redsys->check($key, $request->all()) && $DsResponse <= 99) {
                $checkout->method = 'card';
                $checkout->save();

                $checkout->pay();
            } else {
                $checkout->new();
            }
        } catch (TpvException $e) {
            Log::debug($e->getMessage());
        } catch (Throwable $e) {
            Log::debug($e->getMessage());
        }
    }

    public function success(Request $request, Checkout $checkout)
    {
        if ($request->method && $request->method === 'transfer') {
            $checkout->pending();
        }

        return view('payments.success', [
            'checkout' => $checkout
        ]);
    }

    public function error(Request $request, Checkout $checkout)
    {
        if ($checkout->status === 'disabled') {
            $checkout = Checkout::where('user_id', $checkout->user_id)
                ->where('product_id', $checkout->product_id)
                ->where('status', '!=', 'disabled')
                ->first();
        } else {
            $checkout = $checkout->new();
        }

        return view('payments.error', [
            'checkout' => $checkout
        ]);
    }
}
