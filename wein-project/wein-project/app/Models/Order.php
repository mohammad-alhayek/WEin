<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'title',
        'description',
        'expected_arrival_date',
        'status',
        'tax',
    ];

    protected $casts = [
        'expected_arrival_date' => 'date',
        'tax' => 'decimal:2',
    ];

    public const STATUSES = [
        'Open',
        'Closed',
        'Sorting',
        'Sent',
        'Shipping',
        'Delivery',
        'Delivered',
    ];

    public function isOpen(): bool
    {
        return $this->status === 'Open';
    }

    public function customerOrders(): HasMany
    {
        return $this->hasMany(CustomerOrder::class, 'orders_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(OrderNotification::class, 'order_id');
    }
}
