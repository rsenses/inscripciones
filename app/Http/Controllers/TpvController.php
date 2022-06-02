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
        try {
            $company = $checkout->campaign->partner;
            $key = $company->merchant_key;

            $redsys = new Tpv();

            $parameters = $redsys->getMerchantParameters($request->Ds_MerchantParameters);
            $DsResponse = $parameters['Ds_Response'];
            $DsResponse += 0;

            if ($redsys->check($key, $request->all()) && $DsResponse <= 99) {
                $checkout->update(['method' => 'card']);
                
                $checkout->apply('pay');
                $checkout->save();
            } else {
                $checkout->regenerateId();
            }
        } catch (TpvException $e) {
            Log::debug($e->getMessage());
            $checkout->tpv = $e->getMessage();
            $checkout->save();
        } catch (Throwable $e) {
            Log::debug($e->getMessage());
            $checkout->tpv = $e->getMessage();
            $checkout->save();
        }
    }

    public function success(Request $request, Checkout $checkout)
    {
        if ($request->method && $request->method === 'transfer') {
            $checkout->apply('hang');
        }

        if ($checkout->status === 'processing') {
            $checkout->apply('pay');
        }
        
        $checkout->save();

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

    public function error(Checkout $checkout)
    {
        $checkout = Checkout::where('user_id', $checkout->user_id)
            ->where('status', '!=', 'disabled')
            ->where('token', $checkout->token)
            ->first();

        if (!$checkout) {
            $checkout = $checkout->regenerateId();
        }

        return view('payments.error', [
            'checkout' => $checkout,
            'products' => $checkout->productsArray(),
        ]);
    }
}
