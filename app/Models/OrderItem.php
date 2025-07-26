<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'name',
        'order_id',
        'crop_id',
        'quantity',
        'price',
        'total'
    ];

    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the crop associated with the item.
     */
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
