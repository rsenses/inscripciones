<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Address extends Model
{
    use HasFactory, UsesTenantConnection;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tax_type',
        'tax_id',
        'street',
        'street_number',
        'zip',
        'city',
        'country',
        'state',
        'ofcont',
        'gestor',
        'untram'
    ];

    /**
     * Get the invoices for the address
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->street}, {$this->zip} - {$this->city} ({$this->state}), {$this->country}";
    }
}
