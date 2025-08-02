<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'crop_id', 'region_id', 'order_id', 'created_at'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
