<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class CustomerOrder extends Model
{
    protected $table = 'customer_orders';

    protected $fillable = [
        'orders_id',
        'customer_name',
        'cart_url',
        'notes',
        'price',
        'delivery_price',
        'tax',
        'total_price',
        'password_hash',
        'phone_number',
        'location',
        'is_updated',
        'updated_by_customer_at',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'delivery_price'=> 'decimal:2',
        'tax'           => 'decimal:2',
        'total_price'   => 'decimal:2',
        'is_updated'    => 'boolean',
        'updated_by_customer_at' => 'datetime',
    ];

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password_hash);
    }

    public function calculateTotal(): void
    {
        $subtotal = (float) $this->price + (float) $this->delivery_price;
        $this->total_price = $subtotal + ($subtotal * ((float) $this->tax / 100));
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
