<?php

namespace App\Models;

use App\Events\CheckoutCancelled;
use App\Events\CheckoutPending;
use App\Events\CheckoutAccepted;
use App\Events\RegistrationPaid;
use App\Events\CheckoutDenied;
use App\Events\CheckoutPaid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'checkout_id',
        'unique_id',
        'metadata',
        'status',
        'promo',
        'asigned'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'asigned' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->unique_id = uniqid();
        });
    }

    /**
     * Get the campaing tha owns the registration.
     */
    public function getCampaignAttribute()
    {
        return Campaign::findOrFail($this->product->campaign_id);
    }

    /**
     * Get the checkout associated with the registration.
     */
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    /**
     * Get the product that owns the registration.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    private function changeStatus($status)
    {
        $this->status = $status;
        $this->save();

        return $this;
    }

    public function accept()
    {
        $this->changeStatus('accepted');

        return $this;
    }

    public function invite()
    {
        $this->changeStatus('paid');

        return $this;
    }

    public function cancel()
    {
        $this->changeStatus('cancelled');

        return $this;
    }

    public function pay()
    {
        $this->changeStatus('paid');

        RegistrationPaid::dispatch($this);

        return $this;
    }

    public function hang()
    {
        $this->changeStatus('pending');

        return $this;
    }

    public function deny()
    {
        $this->changeStatus('denied');

        return $this;
    }
}
