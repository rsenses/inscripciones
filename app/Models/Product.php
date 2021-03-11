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
}
