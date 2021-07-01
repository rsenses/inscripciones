<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function terminos(Request $request)
    {
        $request->validate([
            'c' => ['nullable', 'exists:checkouts,id'],
        ]);

        $checkout = null;

        if ($request->c) {
            $checkout = Checkout::find($request->c);
        }

        return view('terminos', [
            'checkout' => $checkout
        ]);
    }

    public function politica()
    {
        return view('politica');
    }
}
