<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    protected $table = 'delivery_areas';

    protected $fillable = ['city_name', 'delivery_price'];

    protected $casts = [
        'delivery_price' => 'decimal:2',
    ];
}
