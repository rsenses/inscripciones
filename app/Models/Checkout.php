<?php

namespace App\Models;

use App\Events\CheckoutBilled;
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

    public function registration($status)
    {
        return Registration::where('user_id', $this->user_id)
            ->where('product_id', $this->product_id)
            ->where('status', $status)
            ->first();
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

        CheckoutPaid::dispatch($checkout);

        return $checkout;
    }

    public function pending()
    {
        $checkout = $this->changeStatus('pending');

        $checkout->update(['method' => 'transfer']);

        CheckoutPaid::dispatch($checkout);

        $registration = $this->registration('accepted');

        $registration->pending();

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

        $checkout->push();

        $this->disable();

        return $checkout;
    }

    public function generatePaymentForm()
    {
        try {
            $company = $this->product->partners[0];

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
            $redsys->setProductDescription($this->product->name);
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
}
