<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Partner;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::all();

        return view('campaigns.index', [
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.create', [
            'partners' => Partner::orderBy('name')->get()
        ]);
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
            'name' => 'required|string|max:255',
            'folder' => 'required|string|max:255',
            'image' => 'required|mimes:jpg,png|max:1000',
            'partner_id' => ['required', 'exists:partners,id']
        ]);

        $campaign = Campaign::create($request->all());

        $path = $request->file('image')->store('campaigns', 'public');

        $campaign->image = $path;
        $campaign->save();

        return redirect()->route('campaigns.edit', [
            'campaign' => $campaign
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', [
            'campaign' => $campaign,
            'partners' => Partner::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpg,png|max:1000',
            'partner_id' => ['required', 'exists:partners,id']
        ]);

        $campaign->update([
            'name' => $request->name,
            'partner_id' => $request->partner_id
        ]);

        if ($request->image) {
            $path = $request->file('image')->store('campaigns', 'public');

            $campaign->image = $path;
            $campaign->save();
        }

        return redirect()->route('campaigns.edit', [
            'campaign' => $campaign
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('campaigns.index');
    }
}
