<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RegistrationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $registrations = $this->collection->map(function ($item, $key) {
            return collect($item)->except(['metadata.products', 'metadata.promo', 'metadata.user_id', 'user.id', 'product.id', 'product.product_id', 'product.url', 'product.description', 'product.price', 'product.mode', 'product.place', 'product.status', 'product.start_date', 'product.end_date'])->toArray();
        });

        return [
            'data' => $registrations,
        ];
    }
}
