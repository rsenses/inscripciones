<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Checkout;
use App\Models\Invoice;
use App\Rules\Nie;
use App\Rules\Nif;
use App\Rules\Cif;
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
        if (!$checkout->user->password) {
            return redirect()->route('preusers.show', ['user' => $checkout->user, 'checkout' => $checkout, 'redirect' => url()->full()]);
        }

        $checkout = Checkout::where('token', $request->t)
            ->where('status', '!=', 'disabled')
            ->first();

        if ($checkout->status === 'processing') {
            $checkout = $checkout->new();
        }

        return view('checkouts.show', [
            'checkout' => $checkout,
            'addresses' => $checkout->user->addresses,
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
                    $taxId = ['alpha_num', 'required', 'size:9', 'regex:/(\d{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1})/', new Nif];
                    break;
                case 'NIE':
                    $taxId = ['alpha_num', 'required', 'size:9', 'regex:/([XYZ]\d{7,8}[A-Z])/', new Nie];
                    break;
                case 'CIF':
                    $taxId = ['alpha_num', 'required', 'size:9', 'regex:/([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])/', new Cif];
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
                'street_number' => 'required',
                'zip' => 'required',
                'city' => 'required',
                'country' => 'required|string|max:2',
                'state' => 'required|string',
                'ofcont' => 'nullable|string',
                'gestor' => 'nullable|string',
                'untram' => 'nullable|string',
                'to_bill' => ['nullable', 'boolean'],
            ]);

            $address = $checkout->user->addresses()->create($request->all());
        }

        $toBill = $request->has('to_bill') && $request->to_bill == 0 ? false : true;

        $invoice = Invoice::firstOrCreate(['checkout_id' => $checkout->id], [
            'address_id' => $address->id,
            'to_bill' => $toBill
        ]);

        $checkout->invoice()->save($invoice);

        return redirect(route('checkouts.payment', ['checkout' => $checkout]));
    }

    /**
     * Payment for the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function payment(Checkout $checkout)
    {
        $form = $checkout->generatePaymentForm();

        $productNames = [];
        $productCounts = [];
        $productPrices = [];
        foreach ($checkout->products->groupBy('id') as $key => $product) {
            $productNames[$key] = $product[0]->name;
            $productCounts[$key] = $product->count();
            $productPrices[$key] = intval($product[0]->price);
        }

        return view('checkouts.payment', [
            'checkout' => $checkout,
            'form' => $form,
            'message' => null,
            'discount' => false,
            'productNames' => $productNames,
            'productCounts' => $productCounts,
            'productPrices' => $productPrices,
        ]);
    }
}
