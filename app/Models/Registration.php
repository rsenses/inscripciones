<?php

namespace App\Models;

use App\Events\RegistrationPaid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'asigned',
        'checkout_id',
        'promo',
        'campaign_id'
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

    /**
     * Check if the registration has benn verified recently, we gave it a 60 seconds margin in case of accidental double validation
     *
     * @return mixed
     */
    public function guardAgainstAlreadyVerifiedRegistration()
    {
        if ($this->status === 'verified') {
            throw new Exception('Acceso realizado anteriormente');
        }
    }
}
