<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrations = Registration::with('product')
            ->latest()
            ->take(50)
            ->get();

        return view('registrations.index', [
            'registrations' => $registrations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::active()->get();

        $users = User::where('role', 'customer')->get();

        return view('registrations.create', [
            'products' => $products,
            'users' => $users
        ]);
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
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('registrations')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id)
                        ->where('product_id', $request->product_id);
                }),
            ],
            'product_id' => [
                'required',
                'exists:products,id',
            ],
        ]);

        $registration = Registration::create($request->except('_token'));

        $registration->accept();

        return redirect()->route('registrations.show', [
            'registration' => $registration
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        return view('registrations.show', [
            'registration' => $registration
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        $products = Product::active()->get();

        $users = User::where('role', 'customer')->get();

        return view('registrations.edit', [
            'registration' => $registration,
            'products' => $products,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('registrations')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id)
                        ->where('product_id', $request->product_id);
                }),
            ],
            'product_id' => [
                'required',
                'exists:products,id',
            ],
        ]);

        $registration->update($request->except('_token'));

        $registration->status = 'accepted';
        $registration->save();

        return redirect()->route('registrations.show', [
            'registration' => $registration
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, Registration $registration)
    {
        $request->validate([
            'action' => [
                'required',
                'in:accept,deny,cancel,pay,invite',
            ],
        ]);

        $action = $request->action;

        $registration->checkout->$action();

        return redirect()->route('products.show', [
            'product' => $registration->product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request, Registration $registration)
    {
        $registration->resendLastEmail();

        return redirect()->route('products.show', [
            'product' => $registration->product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        $checkout = $registration->checkout()->where('status', '!=', 'disabled')->first();

        if ($checkout) {
            $checkout->delete();
        }

        $registration->delete();

        return redirect()->route('registrations.index');
    }
}
