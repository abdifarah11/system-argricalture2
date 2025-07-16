<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'region_id',
        'price',
        'unit',
        'quantity',
        'kg',
        'litre',
    ];

    /**
     * Get the crop associated with the price.
     */
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    /**
     * Get the region where the price applies.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
