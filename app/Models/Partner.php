<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Partner extends Model
{
    use HasFactory, UsesTenantConnection;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'merchant_code',
        'merchant_key',
        'corporation',
    ];

    /**
     * Get the partner that owns the campaign.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the campaigns for the partner.
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * The products that belong to the partner.
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, Campaign::class, 'partner_id', 'campaign_id');
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        $host = str_replace('.localhost', '', request()->getHost());
        $hostNames = explode('.', $host);
        $domain = $hostNames[count($hostNames) - 2];

        return $query->where('slug', $domain);
    }
}
