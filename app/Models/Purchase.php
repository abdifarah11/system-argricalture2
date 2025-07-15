<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
      protected $fillable = [
        'region_id',
        'crop_id',
        'quantity',
        'price_per_unit',
        'total_price',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
