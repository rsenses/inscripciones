<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'due_at',
        'value',
        'uses',
        'type',
        'automatic',
        'min_amount',
        'min_quantity',
        'cumulable',
    ];

    /**
     * Get the parent discountable model (campaign or product).
     */
    public function discountable()
    {
        return $this->morphTo();
    }

    /**
     * Get the deals for the discount.
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function applicable(Checkout $checkout)
    {
        if ($this->discountable_type === 'App\Models\Campaign') {
            if ($checkout->campaign->id !== $this->discountable_id) {
                return false;
            }

            // Si hay min_amount > 0, vemos si la compra vale mas o igual que ese minimo
            if ($this->min_amount > 0 && $this->min_amount > $checkout->amount) {
                return false;
            }
        }

        if ($this->discountable_type === 'App\Models\Product') {
            $productIds = $checkout->products->pluck('id')->toArray();
            if (!in_array($this->discountable_id, $productIds)) {
                return false;
            }

            // Si hay min_quantity > 0, vemos si se compra esa cantidad minima de productos
            if ($this->min_quantity > 0 && $this->min_quantity > $checkout->products()->where('products.id', $this->discountable_id)->count()) {
                return false;
            }
        }

        if ($this->due_at && $this->due_at->isPast()) {
            return false;
        }

        // Si hay uses > 0, en ese caso, si se ha aplicado
        if ($this->uses > 0 && $this->uses <= $this->deals()->count()) {
            return false;
        }

        // Si ya se ha aplicado el descuento
        if ($this->deals()->where('deals.checkout_id', $checkout->id)->count()) {
            return false;
        }

        return true;
    }

    public function amount(Checkout $checkout)
    {
        $amount = 0;

        if ($this->type === 'percentage') {
            if ($this->discountable_type === 'App\Models\Campaign') {
                $originalAmount = 0;

                foreach ($checkout->products as $product) {
                    $originalAmount = $originalAmount + $product->price;
                }
            }
    
            if ($this->discountable_type === 'App\Models\Product') {
                $originalAmount = $this->discountable->price;
                $originalAmount = $originalAmount * $checkout->products()->where('products.id', $this->discountable_id)->count();
            }

            $amount = ($this->value / 100) * $originalAmount;
        }

        if ($this->type === 'fixed') {
            $amount = $this->value;
        }

        return $amount;
    }
}
