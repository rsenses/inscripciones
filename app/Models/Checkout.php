<?php

namespace App\Models;

use App\Events\CheckoutAccepted;
use App\Events\CheckoutDenied;
use App\Events\CheckoutCancelled;
use App\Events\CheckoutPaid;
use App\Events\CheckoutPending;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;
use \Iben\Statable\Statable;

class Checkout extends Model
{
    const PREMIOSMESA_ID = 16;

    use HasFactory, Statable;

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
        'method',
        'status',
        'quantity',
        'tpv'
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
     * Get the invoice associated with the checkout.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the deal associated with the checkout.
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    protected function getGraph()
    {
        return 'checkout'; // the SM config to use
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

    public function regenerateId()
    {
        $checkout = $this->replicate();

        $checkout->push();

        foreach ($this->registrations()->get() as $registration) {
            $registration->update([
                'checkout_id' => $checkout->id,
            ]);
        }

        $this->invoice()->update([
            'checkout_id' => $checkout->id,
        ]);

        $this->apply('disable');
        $this->save();

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

        $newPrice = $originalPrice - $discount->amount($this);

        if ($discount->quantity === 100) {
            $this->apply('pay');
        } else {
            $this->amount = $newPrice;
        }
        
        $this->save();

        $this->deals()->create([
            'discount_id' => $discount->id,
            'amount' => $originalPrice - $newPrice,
        ]);

        return $this;
    }

    public function registrationsStatus(string $status)
    {
        foreach ($this->registrations()->get() as $registration) {
            $registration->$status();
        }

        return $this;
    }

    public function applyAutomaticDiscount()
    {
        $discounts = $this->campaign->discounts()->where('automatic', true)->get();

        foreach ($this->products as $product) {
            $collection = $product->discounts()->where('automatic', true)->get();

            $discounts = $discounts->merge($collection);
        }
 
        // Sobre la colección, primero aplicar los cumulable TRUE, luego el de mayor amount calculado de los NO cumulables
        $cumulables = $discounts->where('cumulable', true);
        $noCumulables = $discounts->where('cumulable', false);
    
        foreach ($cumulables as $discount) {
            if ($discount->applicable($this)) {
                $this->applyDiscount($discount);
            }
        }

        $noCumulableDiscountToApply = null;
        foreach ($noCumulables as $discount) {
            if ($discount->applicable($this)) {
                if ($noCumulableDiscountToApply) {
                    if ($discount->amount($this) > $noCumulableDiscountToApply->amount($this)) {
                        $noCumulableDiscountToApply = $discount;
                    }
                } else {
                    $noCumulableDiscountToApply = $discount;
                }
            }
        }
        if ($noCumulableDiscountToApply) {
            $this->applyDiscount($noCumulableDiscountToApply);
        }

        return $this;
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
                CheckoutAccepted::dispatch($this);
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
