<?php

namespace App\Http\Controllers;

use App\Events\RegistrationAsigned;
use App\Models\Checkout;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegistrationPaid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        $user = $checkout->user;

        return view('tickets.checkout', [
            'checkout' => $checkout,
            'registrations' => $checkout->registrations->where('user_id', $user->id),
            'brand' => $this->getBrand($checkout),
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration, $id)
    {
        if ($registration->unique_id != $id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$registration->asigned) {
            return redirect()->route('tickets.assign', ['registration' => $registration, 'id' => $registration->unique_id]);
        }

        return view('tickets.show', [
            'registration' => $registration,
            'brand' => $this->getBrand($registration->checkout),
        ]);
    }

    /**
     * Show assign form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, Registration $registration, $id)
    {
        if ($registration->unique_id != $id) {
            abort(403, 'Unauthorized action.');
        }

        return view('tickets.assign', [
            'registration' => $registration
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration, $id)
    {
        if ($registration->unique_id != $id) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'tax_id' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:255'],
                'company' => ['nullable', 'string', 'max:255'],
                'position' => ['nullable', 'string', 'max:255'],
                'advertising' => ['nullable', 'boolean']
            ]);

            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tax_id' => $request->tax_id,
                'phone' => $request->phone,
                'company' => $request->company,
                'position' => $request->position,
                'advertising' => $request->advertising ?: 0,
            ]);
        }

        $registration->update([
            'user_id' => $user->id,
            'asigned' => true,
        ]);

        $registration = $registration->fresh();

        RegistrationAsigned::dispatch($registration);

        return redirect()->route('tickets.show', [
            'registration' => $registration,
            'id' => $registration->unique_id
        ]);
    }

    private function getBrand(Checkout $checkout)
    {
        $domain = $checkout->campaign->partner->slug;

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
