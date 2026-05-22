<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OcrTask extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image_path',
        'notes',
        'extracted_text',
        'status',
        'error',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (OcrTask $task): void {
            if (filled($task->slug)) {
                return;
            }

            $task->slug = static::makeUniqueSlug($task->title);
        });

        static::deleted(function (OcrTask $task): void {
            $user = $task->user;

            if (! $user) {
                return;
            }

            $notification = Notification::make()
                ->title('OCR task deleted')
                ->body("\"{$task->title}\" was deleted.")
                ->warning()
                ->icon('heroicon-o-trash');

            $user->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => \Filament\Notifications\DatabaseNotification::class,
                'data' => $notification->getDatabaseMessage(),
            ]);
        });
    }

    protected static function makeUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'ocr-task';
        $slug = $baseSlug;
        $suffix = 2;

        while (static::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
