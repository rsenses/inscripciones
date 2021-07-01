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
            'merchant_code' => ['required', 'string', 'max:255'],
            'merchant_key' => ['required', 'string', 'max:255'],
            'corporation' => ['required', 'string', 'max:255'],
            'conditions' => ['required', 'string'],
            'legal' => ['required', 'string'],
        ]);

        $path = $request->file('image')->store('partners', 'public');

        $partner = Partner::create([
            'name' => $request->name,
            'merchant_code' => $request->merchant_code,
            'merchant_key' => $request->merchant_key,
            'corporation' => $request->corporation,
            'conditions' => $request->conditions,
            'legal' => $request->legal,
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
        $partner = Partner::with(['products' => function ($query) {
            $query->withCount(['registrations' => function ($query) {
                $query->where('status', '!=', 'cancelled');
                $query->where('status', '!=', 'denied');
            }]);
        }])
            ->find($partner->id);

        return view('partners.show', [
            'partner' => $partner
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
            'merchant_code' => ['required', 'string', 'max:255'],
            'merchant_key' => ['required', 'string', 'max:255'],
            'corporation' => ['required', 'string', 'max:255'],
            'conditions' => ['required', 'string'],
            'legal' => ['required', 'string'],
        ]);

        if ($request->image) {
            $path = $request->file('image')->store('partners', 'public');
        }

        $data = [
            'name' => $request->name,
            'merchant_code' => $request->merchant_code,
            'merchant_key' => $request->merchant_key,
            'corporation' => $request->corporation,
            'conditions' => $request->conditions,
            'legal' => $request->legal
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
