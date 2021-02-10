<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the invoice's owner.
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Checkout::class);
    }
}
