<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Registration;
use App\Services\DynamicMailer;
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
            ->whereHas('partners', function (Builder $query) {
                $query->where('slug', DynamicMailer::getDomain());
            })
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
