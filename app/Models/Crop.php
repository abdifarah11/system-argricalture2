<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    //

    protected $fillable = [
        'name',
        'crop_type_id',
        'user_id',
        'region_id',
        'image',
        'description',
    ];


    public function cropType()
    {
        return $this->belongsTo(CropType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
