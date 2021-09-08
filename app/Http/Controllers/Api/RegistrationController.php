<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Events\RegistrationCreated;

class RegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('registrations')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id)
                        ->where('product_id', $request->product_id);
                }),
            ],
            'promo' => 'nullable|string'
        ],
        [
            'product_id.unique' => 'Usuario previamente registrado en este evento.',
        ]);

        $user = User::findOrFail($request->user_id);

        $registration = $user->registrations()->create([
            'product_id' => $request->product_id,
            'promo' => $request->promo,
            'metadata' => $request->all()
        ]);

        if ($registration->product->first_action) {
            $registration->{$registration->product->first_action}();
        } else {
            RegistrationCreated::dispatch($registration);
        }

        return response()->json([
            'registration' => $registration,
            'checkout' => $registration->checkout()
        ]);
    }
}
