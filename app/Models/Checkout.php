<?php

namespace App\Models;

use App\Events\CheckoutBilled;
use App\Events\CheckoutDenied;
use App\Events\CheckoutCancelled;
use App\Events\CheckoutPaid;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

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
        'token',
        'method'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'paid_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // static::creating(function ($model) {
        //     $model->token = uniqid();
        // });
    }

    /**
     * Get the invoice associated with the checkout.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the deal associated with the checkout.
     */
    public function deal()
    {
        return $this->hasOne(Deal::class);
    }

    /**
     * Get the products associated to the checkout.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the user that owns the checkout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the registrations for the checkout
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    private function changeStatus($status)
    {
        $this->status = $status;
        $this->save();

        return $this;
    }

    public function cancel()
    {
        CheckoutCancelled::dispatch($this);

        $checkout = $this->changeStatus('cancelled');

        return $checkout;
    }

    public function disable()
    {
        $checkout = $this->changeStatus('disabled');

        return $checkout;
    }

    public function processing()
    {
        $checkout = $this->changeStatus('processing');

        return $checkout;
    }

    public function pay()
    {
        $checkout = $this->changeStatus('paid');

        $checkout->update(['paid_at' => Carbon::now()]);

        $this->registrationsStatus('pay');

        CheckoutPaid::dispatch($checkout);

        return $checkout;
    }

    public function invite()
    {
        $checkout = $this->changeStatus('paid');

        $checkout->update(['paid_at' => Carbon::now()]);

        $this->registrationsStatus('pay');

        CheckoutPaid::dispatch($checkout);

        return $checkout;
    }

    public function pending()
    {
        $checkout = $this->changeStatus('pending');

        $checkout->update(['method' => 'transfer']);

        $this->registrationsStatus('pending');

        CheckoutPaid::dispatch($checkout);

        return $checkout;
    }

    public function deny()
    {
        $checkout = $this->changeStatus('denied');

        CheckoutDenied::dispatch($checkout);

        $this->registrationsStatus('deny');

        return $checkout;
    }

    public function setInvoice()
    {
        $checkout = $this->changeStatus('billed');

        return $checkout;
    }

    public function new()
    {
        $checkout = $this->replicate();

        $checkout->status = 'accepted';

        $checkout->push();

        $this->disable();

        return $checkout;
    }

    public function generatePaymentForm()
    {
        try {
            $company = $this->products[0]->partners[0];

            $redsys = new Tpv();
            $redsys->setAmount($this->amount);
            $redsys->setOrder(sprintf('%012d', $this->id));
            $redsys->setMerchantcode($company->merchant_code); //Reemplazar por el código que proporciona el banco
            $redsys->setCurrency('978');
            $redsys->setTransactiontype('0');
            $redsys->setTerminal('1');
            $redsys->setMethod('C'); //Solo pago con tarjeta, no mostramos iupay
            $redsys->setNotification(route('tpv.notify', ['checkout' => $this])); //Url de notificacion
            $redsys->setUrlOk(route('tpv.success', ['checkout' => $this])); //Url OK
            $redsys->setUrlKo(route('tpv.error', ['checkout' => $this])); //Url KO
            $redsys->setVersion('HMAC_SHA256_V1');
            $redsys->setTradeName($company->name);
            $redsys->setTitular($this->user->full_name);
            $redsys->setProductDescription("Evento {$company->name} " . now()->year);
            $redsys->setEnvironment(config('app.env') === 'local' ? 'test' : 'live'); //Entorno test
            $redsys->setAttributesSubmit('submit', 'submit', 'Pagar con tarjeta', '', 'btn btn-primary btn-block btn-lg');

            $signature = $redsys->generateMerchantSignature($company->merchant_key);
            $redsys->setMerchantSignature($signature);

            $this->processing();

            return $redsys->createForm();
        } catch (TpvException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function applyDiscount(Discount $discount)
    {
        $originalPrice = $this->amount;

        $newPrice = $originalPrice * ((100 - $discount->quantity) / 100);

        $this->amount = $newPrice;

        $this->save();

        return $this;
    }

    private function registrationsStatus(string $status)
    {
        foreach ($this->registrations()->get() as $registration) {
            $registration->$status();
        }

        return $this;
    }
}
