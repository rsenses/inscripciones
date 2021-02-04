<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Builder;
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
        $activeProducts = Product::active()
            ->withCount(['registrations' => function (Builder $query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->get();

        $latestRegistrations = Registration::latest()->take(10)->get();

        return view('dashboard', [
            'products' => $activeProducts,
            'registrations' => $latestRegistrations
        ]);
    }
}
