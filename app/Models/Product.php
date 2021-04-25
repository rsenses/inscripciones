<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'mode',
        'place',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

        /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->price = $model->price ?: 0.00;
        });
    }

    /**
     * Get the checkouts for the product
     */
    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * The partners that belong to the product.
     */
    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }

    /**
     * Get the registrations for the product.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('end_date', '>', Carbon::now())
            ->where('status', 'active');
    }

    /**
     * Get the registrations count.
     *
     * @param  string  $value
     * @return string
     */
    public function getNewRegistrationsAcceptedCountAttribute($value)
    {
        return $this->registrations()
            ->where('status', 'new')
            ->count();
    }

    /**
     * Get the registrations count.
     *
     * @param  string  $value
     * @return string
     */
    public function getRegistrationsAcceptedCountAttribute($value)
    {
        return $this->registrations()
            ->where('status', '!=', 'new')
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'denied')
            ->count();
    }

    /**
     * Get paid registrations count.
     *
     * @param  string  $value
     * @return string
     */
    public function getPaidRegistrationsAcceptedCountAttribute($value)
    {
        return $this->registrations()
            ->where('status', 'paid')
            ->count();
    }

    /**
     * Get paid pending registrations count.
     *
     * @param  string  $value
     * @return string
     */
    public function getPendingRegistrationsAcceptedCountAttribute($value)
    {
        return $this->registrations()
            ->where('status', 'pending')
            ->count();
    }

    public function getAmountAttribute()
    {
        $paidRegistrations = $this->registrations()
            ->where('status', 'paid')
            ->count();

        return $paidRegistrations * $this->price;
    }
}
