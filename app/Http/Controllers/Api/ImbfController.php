<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ImbfController extends Controller
{
    public function streaming(Request $request)
    {
        $user = auth()->user();

        $products = [17, 18];
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

        return [
            'streaming' => '<iframe width="560" height="349" src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&hd=1" frameborder="0" allowfullscreen ></iframe>'
        ];
    }
}
