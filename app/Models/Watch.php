<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'glb_model'
    ];
}
