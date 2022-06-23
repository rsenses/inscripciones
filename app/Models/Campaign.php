<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'folder',
        'image',
        'partner_id',
    ];

    /*
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'folder',
        'mailer',
        'from_address',
        'from_name',
        'short_name',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the campaign discount
     */
    public function discounts()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

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

    /**
    * Scope a query to only include active products.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query)
    {
        return $query->whereHas('products', function ($query) {
            $query->active();
        });
    }

    public function getCheckoutsCountAttribute()
    {
        return Checkout::whereHas('products', function ($query) {
            $query->where('campaign_id', $this->id);
        })
            ->where('status', 'paid')
            ->where('amount', '>', 0)
            ->count();
    }

    public function getAmountAttribute()
    {
        return Checkout::whereHas('products', function ($query) {
            $query->where('campaign_id', $this->id);
        })
            ->where('status', 'paid')
            ->sum('amount');
    }
}
