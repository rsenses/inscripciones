<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Services\DynamicMailer;

class TicketController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Registration $registration, $id)
    {
        if ($registration->unique_id != $id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$registration->user->password) {
            return redirect()->route('preusers.show', ['user' => $registration->user, 'redirect' => $request->path()]);
        }

        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES');

        $domain = DynamicMailer::getDomain();

        if ($domain === 'telva') {
            $colors = [0, 0, 0];
            $logo = null;
        } else {
            $colors = [28, 119, 107];
            $logo = null;
        }

        return view('tickets.show', [
            'registration' => $registration,
            'colors' => $colors,
            'logo' => $logo,
        ]);
    }
}
