<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'crop_type_id',
        'region_id',
        'user_id',
        'description',
         'image',
    ];

    /**
     * Get the crop type this crop belongs to.
     */
    public function cropType()
    {
        return $this->belongsTo(CropType::class);
    }

    /**
     * Get the region this crop belongs to.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the user who added the crop.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all price entries related to this crop.
     */
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
