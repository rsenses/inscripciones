<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::all();

        return view('partners.index', [
            'partners' => $partners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'mimes:png'],
            'url_payment' => ['required', 'active_url']
        ]);

        $path = $request->file('image')->store('partners', 'public');

        $partner = Partner::create([
            'name' => $request->name,
            'url_payment' => $request->url_payment,
            'image' => $path
        ]);

        return redirect()->route('partners.show', ['partner' => $partner]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        $products = Product::with(['partners' => function ($query) use ($partner) {
                $query->where('partners.id', $partner->id);
            }])
            ->withCount(['registrations' => function ($query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->get();

        return view('partners.show', [
            'partner' => $partner,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return view('partners.edit', [
            'partner' => $partner
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:png'],
            'url_payment' => ['required', 'active_url']
        ]);

        if ($request->image) {
            $path = $request->file('image')->store('partners', 'public');
        }

        $data = [
            'name' => $request->name,
            'url_payment' => $request->url_payment,
        ];

        if (isset($path)) {
            $data['image'] = $path;
        }

        $partner->update($data);

        return redirect()->route('partners.show', ['partner' => $partner]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('partners.index');
    }
}
