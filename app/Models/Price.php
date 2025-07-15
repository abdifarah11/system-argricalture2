<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //

    protected $fillable = [
        'crop_id',
        'region_id',
        'price',
        'unit',
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
