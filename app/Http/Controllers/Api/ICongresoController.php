<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ICongresoController extends Controller
{
    public function streaming(Request $request)
    {
        $user = auth()->user();

        $products = [3, 4];
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
            'streaming1' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Okkd8-L7qEc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
        ];
    }

    public function registrationsNoAuth()
    {
        $productId = 3;

        return $this->getRegistrations($productId);
    }

    private function getRegistrations(int $productId)
    {
        $product = Product::findOrFail($productId);

        $registrations = [];

        foreach ($product->registrations as $registration) {
            if ($registration->status === 'paid') {
                $registrations[] = [
                    'id' => $registration->user->id,
                    'name' => $registration->user->full_name,
                    'dni' => strtoupper($registration->user->tax_id),
                ];
            }
        }

        return $registrations;
    }
}
