<?php

namespace App\Models;

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
        'unique_id',
        'metadata',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
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

        // Lanzamos evento de inscripción aceptada

        return $registration;
    }

    public function deny()
    {
        $registration = $this->changeStatus('denied');

        // Lanzamos evento de inscripción denegada

        return $registration;
    }

    public function cancel()
    {
        $registration = $this->changeStatus('cancelled');

        // Lanzamos evento de inscripción cancelada

        return $registration;
    }

    public function pay()
    {
        $registration = $this->changeStatus('paid');

        // Lanzamos evento de inscripción paid

        return $registration;
    }

}
