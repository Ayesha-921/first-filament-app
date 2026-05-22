<?php

namespace App\Filament\Resources\OcrTaskResource\Pages;

use App\Filament\Resources\OcrTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

class ViewOcrTask extends ViewRecord
{
    protected static string $resource = OcrTaskResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'View OCR Task';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square'),

            DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->successRedirectUrl(static::getResource()::getUrl('index')),
        ];
    }

    public function defaultForm(Schema $schema): Schema
    {
        if (! $schema->hasCustomColumns()) {
            $schema->columns($this->hasInlineLabels() ? 1 : 2);
        }

        return $schema
            ->inlineLabel($this->hasInlineLabels())
            ->model($this->getRecord())
            ->operation('view')
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('OCR Submission')
                ->description('Upload an image to extract its text using the Flask AI service.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->readOnly()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    FileUpload::make('image_path')
                        ->label('Image')
                        ->image()
                        ->required()
                        ->disk('public')
                        ->directory('ocr-uploads')
                        ->visibility('public')
                        ->maxSize(8192)
                        ->disabled()
                        ->columnSpanFull(),

                    Textarea::make('extracted_text')
                        ->label('Extract Text')
                        ->extraInputAttributes(['readonly' => true])
                        ->hint(fn (): HtmlString => new HtmlString(
                            filled($text = $this->record->extracted_text)
                                ? '<button type="button" x-data="{ copied: false }" x-on:click="navigator.clipboard.writeText(' . Js::from($text) . '); copied = true; setTimeout(() => copied = false, 1500)" style="display:inline-flex;align-items:center;gap:0.35rem;color:#7c3aed;font-weight:500;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 8h10.5A1.5 1.5 0 0 1 20 9.5V20a1.5 1.5 0 0 1-1.5 1.5H8A1.5 1.5 0 0 1 6.5 20V9.5A1.5 1.5 0 0 1 8 8Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 15.5V5A1.5 1.5 0 0 1 5.5 3.5H16"/></svg>
                                    <span x-text="copied ? \'Copied\' : \'Copy\'">Copy</span>
                                </button>'
                                : '',
                        ))
                        ->rows(4)
                        ->placeholder('Extracted text will appear here...')
                        ->columnSpanFull(),
                ])->columns(1),
        ]);
    }
}
