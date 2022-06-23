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
        'url',
        'description',
        'price',
        'mode',
        'place',
        'start_date',
        'end_date',
        'campaign_id'
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'image',
        'remember_token',
        'created_at',
        'updated_at',
        'max_quantity',
        'first_action'
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
     * Get the product discounts
     */
    public function discounts()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    /**
     * Get the campaign that owns the product.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the checkouts for the product
     */
    public function checkouts()
    {
        return $this->hasManyThrough(Checkout::class, Registration::class, 'product_id', 'id', 'id', 'checkout_id');
    }

    /**
     * The partners that belong to the product.
     */
    public function partner()
    {
        return $this->hasOneThrough(Partner::class, Campaign::class, 'partner_id', 'id', 'campaign_id');
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
    public function getNewRegistrationsCountAttribute($value)
    {
        return $this->registrations()
            ->where('registrations.status', 'new')
            ->count();
    }

    /**
     * Get the registrations accepted count.
     *
     * @return string
     */
    public function getRegistrationsAcceptedCountAttribute()
    {
        return $this->registrations()
            ->where('registrations.status', '!=', 'new')
            ->where('registrations.status', '!=', 'cancelled')
            ->where('registrations.status', '!=', 'denied')
            ->count();
    }

    /**
     * Get the registrations not paid count.
     *
     * @return string
     */
    public function getRegistrationsPendingCountAttribute()
    {
        return $this->registrations()
            ->where(function ($q) {
                $q->where('registrations.status', 'accepted');
                $q->orWhere('registrations.status', 'pending');
            })
            ->count();
    }

    /**
     * Get paid registrations paid count.
     *
     * @param  string  $value
     * @return string
     */
    public function getRegistrationsPaidCountAttribute()
    {
        return $this->registrations()
            ->where('registrations.status', 'paid')
            ->count();
    }

    /**
     * Get the registrations count.
     *
     * @return string
     */
    public function getRegistrationsDeniedCountAttribute()
    {
        return $this->registrations()
            ->where('registrations.status', 'denied')
            ->count();
    }

    /**
     * Get the registrations count.
     *
     * @return string
     */
    public function getRegistrationsCancelledCountAttribute()
    {
        return $this->checkouts()
            ->where('checkouts.status', 'cancelled')
            ->count();
    }
}
