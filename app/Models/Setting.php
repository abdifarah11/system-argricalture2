<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'system_name', 'phone', 'address', 'url', 'email', 'logo_path',
    ];
}
