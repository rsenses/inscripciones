<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['checkout_id', 'discount_id', 'amount'];

    /**
     * Get the checkout associated with the deal.
     */
    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    /**
     * Get the discount associated with the deal.
     */
    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
}
