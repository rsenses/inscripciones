<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IICongresoController extends Controller
{
    public function streaming(Request $request)
    {
        $user = auth()->user();

        $products = [7, 9];
        $paid = false;

        foreach ($user->registrations as $registration) {
            if ($registration->status === 'paid') {
                if (in_array($registration->product_id, $products)) {
                    $paid = true;
                }
            }
        }

        if (!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $this->getStream($request->lang);
    }

    private function getStream($lang = 'es')
    {
        return [
            'congreso' => 'tOzBGN95gEU',
            'meditacion' => 'DWJwhJX5b3E',
            'health' => 'wrjvdzLoV1E',
            'alimentos' => 'OtAndny1ias',
            'piel' => 'aIL_hnux28k',
        ];
    }
}
