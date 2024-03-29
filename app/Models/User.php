<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UsesTenantConnection;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'tax_id',
        'phone',
        'company',
        'position',
        'role',
        'advertising',
        'data'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'advertising',
        'role'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'data' => 'array',
        'advertising' => 'boolean'
    ];

    /**
     * Get the addresses for the user
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the checkouts for the user
     */
    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * Get all of the invoices for the user.
     */
    public function invoices()
    {
        return $this->hasManyThrough(Invoices::class, Checkout::class);
    }

    /**
     * Get the registrations for the user.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameUppercaseAttribute()
    {
        return "{$this->name} " . strtoupper($this->last_name);
    }


    public function redirectIfNotPasswordSet()
    {
        if (!$this->password) {
        }
    }
}
