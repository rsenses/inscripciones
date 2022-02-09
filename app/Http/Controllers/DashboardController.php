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
        $host = str_replace('.localhost', '', request()->getHost());
        $hostNames = explode('.', $host);
        $domain = $hostNames[count($hostNames) - 2];

        $activeProducts = Product::active()
            ->withCount(['registrations' => function (Builder $query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->whereHas('partners', function (Builder $query) use ($domain) {
                $query->where('slug', $domain);
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
