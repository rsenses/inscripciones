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
        'to_bill'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'billed_at' => 'datetime:Y-m-d H:i:s',
        'to_bill' => 'boolean',
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
