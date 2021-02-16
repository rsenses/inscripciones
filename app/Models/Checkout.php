<?php

namespace App\Models;

use App\Events\CheckoutBilled;
use App\Events\CheckoutCancelled;
use App\Events\CheckoutPaid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'amount',
        'paid_at',
        'token'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->token = uniqid();
        });
    }

    /**
     * Get the invoice associated with the checkout.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the product that owns the checkout.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the checkout.
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

    public function cancel()
    {
        $checkout = $this->changeStatus('cancelled');

        CheckoutCancelled::dispatch($checkout);

        return $checkout;
    }

    public function pay()
    {
        $checkout = $this->changeStatus('paid');

        $checkout->update(['paid_at' => Carbon::now()]);

        CheckoutPaid::dispatch($checkout);

        return $checkout;
    }

    public function setInvoice()
    {
        $checkout = $this->changeStatus('billed');

        return $checkout;
    }
}
