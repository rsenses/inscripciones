<?php

namespace App\Models;

use App\Events\CheckoutCancelled;
use App\Events\CheckoutPending;
use App\Events\CheckoutAccepted;
use App\Events\RegistrationPaid;
use App\Events\CheckoutDenied;
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
    public function campaign()
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
        $registration = $this->changeStatus('accepted');

        return $registration;
    }

    public function invite()
    {
        $registration = $this->changeStatus('paid');

        return $registration;
    }

    public function cancel()
    {
        $registration = $this->changeStatus('cancelled');

        return $registration;
    }

    public function pay()
    {
        $registration = $this->changeStatus('paid');

        RegistrationPaid::dispatch($this);

        return $registration;
    }

    public function pending()
    {
        $registration = $this->changeStatus('pending');

        return $registration;
    }

    public function deny()
    {
        $registration = $this->changeStatus('denied');

        return $registration;
    }

    public function resendLastEmail()
    {
        $this->sendEventByStatus($this->status);

        return $this;
    }

    private function sendEventByStatus(string $status)
    {
        switch ($status) {
            case 'accepted':
                $invite = false;
                $sendEmail = true;

                CheckoutAccepted::dispatch($this->checkout, $invite, $sendEmail);
                break;
            case 'paid':
                RegistrationPaid::dispatch($this);
                break;
            case 'pending':
                CheckoutPending::dispatch($this->checkout);
                break;
            case 'denied':
                CheckoutDenied::dispatch($this->checkout);
                break;
            case 'cancelled':
                CheckoutCancelled::dispatch($this->checkout);
                break;
            default:
                RegistrationPaid::dispatch($this);
                break;
        }
    }
}
