<?php

namespace App\Http\Controllers;

use App\Events\CheckoutPaid;
use App\Models\Checkout;
use Carbon\Carbon;
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

            Log::debug($parameters);

            if ($redsys->check($key, $request->all()) && $DsResponse <= 99) {
                $checkout->method = 'card';
                $checkout->save();

                $checkout->pay();

                $checkout->registration->pay();

                // Evento compra confirmada para mandar email
            } else {
                $newCheckout = $checkout->replicate();

                $newCheckout->push();

                $checkout->delete();
            }
        } catch (TpvException $e) {
            Log::debug($e->getMessage());
        } catch (Throwable $e) {
            Log::debug($e->getMessage());
        }
    }

    public function success(Checkout $checkout)
    {
        CheckoutPaid::dispatch($checkout);

        return view('payments.success', [
            'checkout' => $checkout
        ]);
    }

    public function error(Request $request, Checkout $checkout)
    {
        // Supuestamente esto no es necesario, se hace en notify
        /* $redsys = new Tpv(); */

        /* $parameters = $redsys->getMerchantParameters($request->Ds_MerchantParameters); */

        /* if (!empty($parameters['Ds_Response']) && $parameters['Ds_Response'] == 9051) { */
        /*     $newCheckout = $checkout->replicate(); */

        /*     $newCheckout->push(); */

        /*     $newCheckout->invoice()->save($checkout->invoice); */

        /*     $checkout->delete(); */

        /*     $checkout = $newCheckout; */
        /* } */

        return view('payments.error', [
            'checkout' => $checkout
        ]);
    }
}
