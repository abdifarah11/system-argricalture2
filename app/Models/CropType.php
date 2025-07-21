<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropType extends Model
{
    //
     protected $fillable = [
        'name',
        'image',
        'description',
    ];

    // Optional: One crop type has many crops
    public function crops()
    {
        return $this->hasMany(Crop::class);
    }

    
}
