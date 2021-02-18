<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

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
        'corporation'
    ];

    /**
     * The products that belong to the partner.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
