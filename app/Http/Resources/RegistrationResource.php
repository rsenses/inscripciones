<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $metadata = $this->metadata;
        unset($metadata['promo'], $metadata['products'], $metadata['user_id']);

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,
            "unique_id" => $this->unique_id,
            "type" => $this->type,
            "metadata" => $metadata,
            "user" => [
                "name" => $this->user->name,
                "email" => $this->user->email,
                "last_name" => $this->user->last_name,
                "tax_id" => $this->user->tax_id,
                "phone" => $this->user->phone,
                "company" => $this->user->company,
                "position" => $this->user->position,
                "data" => $this->user->data
            ],
            "product" => [
                "name" => $this->product->name
            ]
        ];
    }
}
