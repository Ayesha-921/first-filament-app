<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = ['name', 'email', 'bio', 'avatar', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
