<?php

namespace App\Filament\Resources\OcrTaskResource\Pages;

use App\Filament\Resources\OcrTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOcrTasks extends ListRecords
{
    protected static string $resource = OcrTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New OCR Task'),
        ];
    }
}
