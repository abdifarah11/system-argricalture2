<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;
    protected $table='price_history';

    protected $fillable = [
        'crop_id',
        'region_id',
        'price',
        'unit',
        'quantity',
        'kg',
        'litre',
    ];

    // Relationships

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
