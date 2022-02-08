<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Services\DynamicMailer;

class TicketController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function showCheckout(Checkout $checkout, $token)
    {
        if ($checkout->token != $token) {
            abort(403, 'Unauthorized action.');
        }

        return view('tickets.checkout', [
            'checkout' => $checkout,
            'brand' => $this->getBrand(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Registration $registration, $id)
    {
        if ($registration->unique_id != $id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$registration->asigned) {
            return redirect()->route('preusers.show', ['user' => $registration->user, 'checkout' => $registration->checkout, 'redirect' => $request->path()]);
        }

        return view('tickets.show', [
            'registration' => $registration,
            'brand' => $this->getBrand(),
        ]);
    }

    private function getBrand()
    {
        $domain = DynamicMailer::getDomain();

        if ($domain === 'telva') {
            $color = [0, 0, 0];
            $logo = null;
        } else {
            $color = [28, 119, 107];
            $logo = null;
        }

        return [
            'logo' => $logo,
            'color' => $color,
        ];
    }
}
