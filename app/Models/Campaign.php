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
