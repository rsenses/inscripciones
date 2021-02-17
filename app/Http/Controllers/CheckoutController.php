<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Checkout;
use App\Models\Invoice;
use App\Rules\Nie;
use App\Rules\Nif;
use Illuminate\Http\Request;
use Sermepa\Tpv\Tpv;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Checkout $checkout)
    {
        $checkout = Checkout::where('id', $checkout->id)
            ->where('token', $request->t)
            ->first();

        return view('checkouts.show', [
            'checkout' => $checkout,
            'addresses' => $checkout->user->addresses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        if ($request->has('address_id')) {
            $request->validate([
                'address_id' => ['required', 'exists:addresses,id']
            ]);

            $address = Address::find($request->address_id);
        } else {
            switch ($request->tax_type) {
                case 'NIF':
                    $taxId = ['alpha_num', new Nif, 'required', 'size:9', 'regex:/(\d{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1})/'];
                    break;
                case 'NIE':
                    $taxId = ['alpha_num', new Nie, 'required', 'size:9', 'regex:/([XYZ]\d{7,8}[A-Z])/'];
                    break;
                case 'CIF':
                    $taxId = ['alpha_num', 'required', 'size:9', 'regex:/([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])/'];
                    break;
                case 'Pasaporte':
                    $taxId = ['alpha_num', 'required', 'min:6', 'max:12'];
                    break;
                default:
                    $taxId = ['required'];
                    break;
            }

            $request->validate([
                'name' => 'required|max:255',
                'tax_type' => 'required|in:CIF,NIF,NIE,Pasaporte,Extranjero',
                'tax_id' => $taxId,
                'street' => 'required',
                'zip' => 'required',
                'city' => 'required',
                'country' => 'required|string|max:2',
                'state' => 'required|string',
            ]);

            $address = $checkout->user->addresses()->create($request->all());
        }

        $checkout->invoice()->create([
            'address_id' => $address->id
        ]);

        $form = $checkout->generatePaymentForm();

        return view('checkouts.payment', [
            'checkout' => $checkout,
            'address' => $address,
            'form' => $form
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
}
