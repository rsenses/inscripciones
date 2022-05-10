<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Invoice;
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

        $activeCampaigns = $partner->campaigns()
            ->active()
            ->get();
        
        $invoices = Invoice::whereHas('checkout', function ($q) use ($partner, $activeCampaigns) {
            $q->whereHas('products', function ($q) use ($partner, $activeCampaigns) {
                $q->whereHas('campaign', function ($q) use ($partner, $activeCampaigns) {
                    $activeCampaignsArray = $activeCampaigns->pluck('id')->toArray();
                    $q->whereIn('campaign_id', $activeCampaignsArray);
                    $q->where('partner_id', $partner->id);
                });
            });
        })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('dashboard', [
            'products' => $activeProducts,
            'campaigns' => $activeCampaigns,
            'invoices' => $invoices
        ]);
    }
}
