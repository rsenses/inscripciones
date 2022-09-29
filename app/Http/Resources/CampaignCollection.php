<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $campaigns = $this->collection->map(function ($item, $key) {
            return collect($item)->except(['partner_id', 'conditions', 'legal'])->toArray();
        });

        return [
            'data' => $campaigns,
        ];
    }
}
