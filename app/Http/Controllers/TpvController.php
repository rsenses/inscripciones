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
            $company = $checkout->campaign->partner;
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

        if ($checkout->status === 'processing') {
            $checkout->pay();
        }

        $productNames = [];
        $productCounts = [];
        $productPrices = [];
        foreach ($checkout->products->groupBy('id') as $key => $product) {
            $productNames[$key] = $product[0]->name;
            $productCounts[$key] = $product->count();
            $productPrices[$key] = intval($product[0]->price);
        }

        return view('payments.success', [
            'checkout' => $checkout,
            'productNames' => $productNames,
            'productCounts' => $productCounts,
            'productPrices' => $productPrices,
        ]);
    }

    public function error(Request $request, Checkout $checkout)
    {
        if ($checkout->status === 'disabled') {
            $checkout = Checkout::where('user_id', $checkout->user_id)
                ->where('status', '!=', 'disabled')
                ->where('token', $checkout->token)
                ->first();
        } else {
            $checkout = $checkout->new();
        }

        $productNames = [];
        $productCounts = [];
        $productPrices = [];
        foreach ($checkout->products->groupBy('id') as $key => $product) {
            $productNames[$key] = $product[0]->name;
            $productCounts[$key] = $product->count();
            $productPrices[$key] = intval($product[0]->price);
        }

        return view('payments.error', [
            'checkout' => $checkout,
            'productNames' => $productNames,
            'productCounts' => $productCounts,
            'productPrices' => $productPrices,
        ]);
    }
}
