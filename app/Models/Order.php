<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'buyer_id',
        'status',
        'total_amount',
    ];

    /**
     * Order belongs to a buyer (User)
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
