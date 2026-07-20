<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'status',
        'name',
        'email',
        'phone',
        'address',
        'items',
        'total_price',
        'payment_method',
    ];
}
