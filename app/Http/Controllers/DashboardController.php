<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $partner = Partner::current()->first();

        $activeProducts = $partner->products()
            ->active()
            ->get();

        $latestRegistrations = Registration::latest()
            ->where('status', 'new')
            ->get();

        return view('dashboard', [
            'products' => $activeProducts,
            'registrations' => $latestRegistrations
        ]);
    }
}
