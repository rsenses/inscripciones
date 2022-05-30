<?php

namespace App\Models;

use App\Events\CheckoutAccepted;
use App\Events\CheckoutDenied;
use App\Events\CheckoutCancelled;
use App\Events\CheckoutPaid;
use App\Events\CheckoutPending;
use App\Services\Discounts;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

class Checkout extends Model
{
    const PREMIOSMESA_ID = 16;

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
     * Get the campaing tha owns the checkout.
     */
    public function getCampaignAttribute()
    {
        return Campaign::findOrFail($this->products[0]->campaign_id);
    }

    /**
     * Get the products associated to the checkout.
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, Registration::class, 'checkout_id', 'id', 'id', 'product_id');
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
        $this->changeStatus('cancelled');
        $this->registrationsStatus('cancel');

        CheckoutCancelled::dispatch($this);

        return $this;
    }

    public function disable()
    {
        $this->changeStatus('disabled');

        return $this;
    }

    public function processing()
    {
        $this->changeStatus('processing');

        return $this;
    }

    public function pay()
    {
        $this->changeStatus('paid');
        $this->update(['paid_at' => Carbon::now()]);

        $this->registrationsStatus('pay');

        CheckoutPaid::dispatch($this);

        return $this;
    }

    public function invite()
    {
        $this->update(['paid_at' => Carbon::now(), 'amount' => 0]);

        $this->changeStatus('paid');
        $this->registrationsStatus('pay');

        CheckoutPaid::dispatch($this);

        return $this;
    }

    public function accept()
    {
        if ($this->amount > 0) {
            $this->changeStatus('accepted');
            $this->registrationsStatus('accept');

            CheckoutAccepted::dispatch($this);
        } else {
            $this->pay();
        }

        return $this;
    }

    public function pending()
    {
        $this->changeStatus('pending');
        $this->registrationsStatus('pending');

        $this->update(['method' => 'transfer']);

        CheckoutPending::dispatch($this);

        return $this;
    }

    public function deny()
    {
        $this->changeStatus('denied');
        $this->registrationsStatus('deny');

        CheckoutDenied::dispatch($this);

        return $this;
    }

    public function new()
    {
        $checkout = $this->replicate();

        $checkout->status = 'accepted';

        $checkout->push();

        foreach ($this->registrations()->get() as $registration) {
            $registration->update([
                'checkout_id' => $checkout->id,
            ]);
        }

        $this->invoice()->update([
            'checkout_id' => $checkout->id,
        ]);

        $this->disable();

        return $checkout;
    }

    public function generatePaymentForm()
    {
        try {
            $company = $this->campaign->partner;

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
        $originalPrice = 0;

        foreach ($this->products as $product) {
            $originalPrice = $originalPrice + $product->price;
        }

        $newPrice = $originalPrice * ((100 - $discount->quantity) / 100);

        if ($discount->quantity === 100) {
            $this->update(['paid_at' => Carbon::now(), 'amount' => 0]);
            $this->changeStatus('paid');
            $this->registrationsStatus('pay');

            CheckoutPaid::dispatch($this);
        } else {
            $this->amount = $newPrice;
            $this->save();
        }

        return $this;
    }

    private function registrationsStatus(string $status)
    {
        foreach ($this->registrations()->get() as $registration) {
            $registration->$status();
        }

        return $this;
    }

    public function CheckForDiscounts()
    {
        $iiCongreso = Discounts::iiCongreso($this);
        $jornadaCF = Discounts::jornadaCF($this);
        
        if ($iiCongreso) {
            return $iiCongreso;
        }

        if ($jornadaCF) {
            return $jornadaCF;
        }

        return false;
    }

    public function applyAutomaticDiscount()
    {
        $discount = $this->CheckForDiscounts();

        if ($discount) {
            $this->amount = $this->amount - $discount['amount'];
            $this->save();
        }
    }

    public function mode()
    {
        $modes = $this->products->groupBy('mode');

        $count = [];
        foreach ($modes as $mode => $products) {
            $count[$mode] = $products->count();
        }

        return $count;
    }

    public function resendLastEmail()
    {
        $this->sendEventByStatus();

        return $this;
    }

    private function sendEventByStatus()
    {
        switch ($this->status) {
            case 'accepted':
                $invite = false;
                $sendEmail = true;

                CheckoutAccepted::dispatch($this, $invite, $sendEmail);
                break;
            case 'paid':
                CheckoutPaid::dispatch($this);
                break;
            case 'pending':
                CheckoutPending::dispatch($this);
                break;
            case 'denied':
                CheckoutDenied::dispatch($this);
                break;
            case 'cancelled':
                CheckoutCancelled::dispatch($this);
                break;
        }
    }

    public function productQuantity($id)
    {
        if ($this->products()->where('products.id', self::PREMIOSMESA_ID)->count()) {
            return 1;
        }

        return $this->products->where('id', $id)->count();
    }
}
