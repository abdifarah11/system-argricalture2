<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crop_id',
        'order_id',
        'payment_method_id',
        'amount',
        'status',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /* ───────────── Relationships ───────────── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
