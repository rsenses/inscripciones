<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    /**
     * Get the partner that owns the campaign.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the products for the campaign.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
