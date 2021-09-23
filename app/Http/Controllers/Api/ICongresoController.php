<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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
            'test_mañana' => 'XntGUHCjKWc',
            'mañana' => 'nGBLFkKYjJI',
            'test_tarde' => 'CtF9aLqI3Ro',
            'tarde' => '80x88C0eH1I',
            'test_taller_salud' => '6qzcEDScwAs',
            'taller_salud' => 'zK7d_TLLIKo',
            'test_taller_escucha' => 'iIJF5O6lomE',
            'taller_escucha' => 'O08o16E8Rew',
            'test_taller_meditacion' => 'YQ7K8G7BF34',
            'taller_meditacion' => 'dlPvq2Uozlk',
            'test_taller_humor' => 'WhOX3tUx9k4',
            'taller_humor' => 'b31qp4lvXJA',
            'test_gratis' => 'r3TK1xEeNW4',
            'gratis' => 'EPPSYwAsDY4'
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
