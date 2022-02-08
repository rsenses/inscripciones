<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Checkout;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function terminos(Request $request)
    {
        $request->validate([
            'c' => ['required', 'exists:campaigns,id'],
        ]);

        $campaign = null;

        if ($request->c) {
            $campaign = Campaign::find($request->c);
        }

        return view('terminos', [
            'campaign' => $campaign
        ]);
    }

    public function politica(Request $request)
    {
        $request->validate([
            'c' => ['required', 'exists:campaigns,id'],
        ]);

        $campaign = null;

        if ($request->c) {
            $campaign = Campaign::find($request->c);
        }

        return view('politica', [
            'campaign' => $campaign
        ]);
    }
}
