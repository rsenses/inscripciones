<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IIForoController extends Controller
{
    public function streaming()
    {
        $user = auth()->user();

        $products = [1, 2];
        $paid = false;

        foreach ($user->registrations as $registration) {
            if($registration->status === 'paid') {
                if(in_array($registration->product_id, $products)) {
                    $paid = true;
                }
            }
        }

        if(!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // Cuando tentamos el streaming, hacer wrap con
        //     <div class="embed-responsive embed-responsive-16by9">
        return [
            'streaming' => '<div class="alert alert-warning">Streaming no disponible actualmente.</div>'
        ];
    }

    public function streamingNoAuth()
    {
        $url = urlencode("https://foro.expansion.com/live.json");

        $json = json_decode(file_get_contents($url), true);

        dd($json);
        // Cuando tentamos el streaming, hacer wrap con
        //     <div class="embed-responsive embed-responsive-16by9">
        return [
            'streaming' => '<div class="alert alert-warning">Streaming no disponible actualmente.</div>'
        ];
    }

    private function getSession()
    {
        $url = urlencode("https://foro.expansion.com/live.json");

        $json = json_decode(file_get_contents($url), true);

        dd($json);
    }

    public function registrations()
    {
        $user = auth()->user();

        $products = [1, 2];
        $paid = false;
        $productId = null;

        foreach ($user->registrations as $registration) {
            if($registration->status === 'paid') {
                if(in_array($registration->product_id, $products)) {
                    $paid = true;
                    $productId = $registration->product_id;
                }
            }
        }

        if(!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $url = 'https://foro.expansion.com/api/speakers.json';
        $JSON = file_get_contents($url);

        $speakers = json_decode($JSON, true);

        $product = Product::findOrFail($productId);

        $registrations = [];

        foreach ($product->registrations as $registration) {
            if($registration->status === 'paid') {
                $registrations[] = [
                    'name' => $registration->user->full_name_uppercase,
                    'last_name' => strtoupper($registration->user->last_name),
                    'description' => $registration->user->position . ', ' . $registration->user->company,
                    'speaker' => false,
                    'online' => false,
                ];
            }
        }

        $registrations = array_merge($speakers, $registrations);

        $lastName = array_column($registrations, 'last_name');

        array_multisort($lastName, SORT_ASC, $registrations);

        $sortedRegistrations = [];

        foreach($registrations as $registration) {
            $first_letter = mb_substr($registration['last_name'], 0, 1, 'UTF-8');

            $sortedRegistrations[$first_letter][] = $registration;
        }

        return $sortedRegistrations;
    }
}
