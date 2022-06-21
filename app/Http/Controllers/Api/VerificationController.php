<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Checkout;

class VerificationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  $uniqueId
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, string $uniqueId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $checkout = Checkout::where('unique_id', $uniqueId)
                ->first();

            if ($checkout) {
                $registration = $checkout->registrations()
                    ->where('product_id', $request->product_id)
                    ->firstOrFail();
            } else {
                $registration = Registration::where('unique_id', $uniqueId)
                    ->where('product_id', $request->product_id)
                    ->firstOrFail();
            }
        } catch (\Throwable $th) {
            abort(403, 'Registro no existente');
        }
        
        try {
            $registration->guardAgainstAlreadyVerifiedRegistration($request);
        } catch (\Throwable $th) {
            abort(403, $th->getMessage());
        }

        $registration->status = 'verified';
        $registration->save();

        return $registration;
    }
}
