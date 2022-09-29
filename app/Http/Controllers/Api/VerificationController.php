<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegistrationResource;
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
    public function update(Request $request, string $uniqueId)
    {
        $request->validate([
            'product_id' => 'required_without:campaign_id|exists:products,id',
            'campaign_id' => 'required_without:product_id|exists:campaigns,id',
        ]);

        try {
            $checkout = Checkout::where('token', $uniqueId)
                ->first();

            if ($checkout) {
                $registration = $checkout->registrations()
                    ->with(['user', 'product'])
                    ->where('unique_id', $uniqueId)
                    ->where(function ($q) use ($request) {
                        if ($request->campaign_id) {
                            $q->whereHas('product', function ($q) use ($request) {
                                return $q->where('campaign_id', $request->campaign_id);
                            });
                        } else {
                            $q->where('product_id', $request->product_id);
                        }
                    })
                    ->firstOrFail();
            } else {
                $registration = Registration::with(['user', 'product'])->where('unique_id', $uniqueId)
                    ->where(function ($q) use ($request) {
                        if ($request->campaign_id) {
                            $q->whereHas('product', function ($q) use ($request) {
                                return $q->where('campaign_id', $request->campaign_id);
                            });
                        } else {
                            $q->where('product_id', $request->product_id);
                        }
                    })
                    ->firstOrFail();
            }
        } catch (\Throwable $th) {
            abort(403, 'Registro no existente: '. $th->getMessage());
        }
        
        try {
            $registration->guardAgainstAlreadyVerifiedRegistration($request);
        } catch (\Throwable $th) {
            abort(403, $th->getMessage());
        }

        $registration->status = 'verified';
        $registration->save();

        return new RegistrationResource($registration);
    }
}
