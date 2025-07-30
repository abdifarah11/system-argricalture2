<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports'; // ✅ this is important

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
