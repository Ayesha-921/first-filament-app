<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 'long_description',
        'price', 'stock', 'sku', 'image', 'images',
        'brand_id', 'category_id', 'is_active', 'is_featured',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'images'      => 'array',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
