<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstantOrder extends Model
{
    protected $table = 'instant_orders';

    protected $fillable = [
        'title',
        'description',
        'product_url',
        'image_url',
        'price',
        'delivery_price',
        'quantity',
        'specifications',
        'status',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'delivery_price' => 'decimal:2',
        'quantity'       => 'integer',
    ];

    public const STATUSES = ['Available', 'SoldOut', 'Hidden'];

    public function reservations(): HasMany
    {
        return $this->hasMany(InstantOrderReservation::class, 'instant_order_id');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'Available' && $this->quantity > 0;
    }
}
