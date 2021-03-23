<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'checkout_id',
        'address_id',
    ];

    /**
     * Get the address that owns the invoice.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the checkout that owns the invoice.
     */
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }
}
