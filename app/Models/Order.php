<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        //'crop_id',
        'payment_method_id',
        'status',
        'total_amount',
        'description',
        'delivery_status',

    ];

    /**
     * Get the user who made the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the crop associated with the order.
     */
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    /**
     * Get the payment method used for this order.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
