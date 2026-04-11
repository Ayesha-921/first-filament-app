<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'number', 'customer_id', 'total_price', 'status',
        'payment_status', 'shipping_address', 'notes',
    ];

    protected $casts = ['total_price' => 'decimal:2'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
