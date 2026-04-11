<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Database\Eloquent\Model;

class WhiteAvatarProvider implements AvatarProvider
{
    public function get(Model $record): string
    {
        if (! empty($record->avatar)) {
            return \Illuminate\Support\Facades\Storage::url($record->avatar);
        }

        $name = \Filament\Facades\Filament::getUserName($record);
        $initials = collect(explode(' ', $name))
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->implode('');

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">'
            . '<circle cx="64" cy="64" r="64" fill="#ffffff"/>'
            . '<text x="50%" y="50%" dominant-baseline="central" text-anchor="middle" '
            . 'font-family="sans-serif" font-size="52" font-weight="700" fill="#111827">'
            . htmlspecialchars($initials)
            . '</text></svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
