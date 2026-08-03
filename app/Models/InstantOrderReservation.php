<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class InstantOrderReservation extends Model
{
    protected $table = 'instant_order_reservations';

    protected $fillable = [
        'instant_order_id',
        'customer_name',
        'phone_number',
        'location',
        'quantity',
        'notes',
        'password_hash',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password_hash);
    }

    public function instantOrder(): BelongsTo
    {
        return $this->belongsTo(InstantOrder::class, 'instant_order_id');
    }
}
