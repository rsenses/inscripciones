<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ICongresoController extends Controller
{
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
