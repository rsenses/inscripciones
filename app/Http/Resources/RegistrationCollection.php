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
            return collect($item)->except(['status', 'metadata.products', 'metadata.promo', 'metadata.user_id', 'created_at', 'updated_at', 'asigned', 'user.email_verified_at', 'user.created_at', 'user.updated_at', 'user.advertising', 'user.id', 'user.role', 'product.id', 'product.product_id', 'product.url', 'product.description', 'product.price', 'product.mode', 'product.image', 'product.place', 'product.status', 'product.start_date', 'product.end_date', 'product.created_at', 'product.updated_at', 'product.first_action', 'product.max_quantity', 'campaign_id', 'promo', 'checkout_id'])->toArray();
        });

        return [
            'data' => $registrations,
        ];
    }
}
