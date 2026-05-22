<?php

namespace App\Filament\Resources\OcrTaskResource\Pages;

use App\Filament\Resources\OcrTaskResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditOcrTask extends EditRecord
{
    protected static string $resource = OcrTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function afterSave(): void
    {
        $user = $this->record->user;

        if (! $user) {
            return;
        }

        $notification = Notification::make()
            ->title('OCR task updated')
            ->body("\"{$this->record->title}\" was updated.")
            ->info()
            ->icon('heroicon-o-pencil-square')
            ->actions([
                Action::make('view')
                    ->label('View task')
                    ->url(static::getResource()::getUrl('view', ['record' => $this->record]))
                    ->markAsRead(),
            ]);

        $user->notifications()->create([
            'id' => (string) Str::uuid(),
            'type' => \Filament\Notifications\DatabaseNotification::class,
            'data' => $notification->getDatabaseMessage(),
        ]);
    }
}
