<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    //
     protected $fillable = [
        'region_id',
        'crop_id',
        'price',
        'unit',
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
