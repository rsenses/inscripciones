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
        $user = auth()->user();

        $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('registrations')->where(function ($query) use($request, $user) {
                    return $query->where('user_id', $user->id)
                    ->where('product_id', $request->product_id);
                }),
            ],
        ]);

        $registration = $user->registrations()->create([
            'product_id' => $request->product_id,
            'metadata' => $request->all()
        ]);

        RegistrationCreated::dispatch($registration);

        return response()->json($registration);
    }
}
