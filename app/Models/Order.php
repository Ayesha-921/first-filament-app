<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'email', 'first_name', 'last_name',
        'address', 'city', 'postal_code', 'phone', 'total',
        'payment_method', 'payment_status', 'status', 'transaction_id', 'notes',
        'number', 'customer_id', 'total_price', 'shipping_address', 'email_sent',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
