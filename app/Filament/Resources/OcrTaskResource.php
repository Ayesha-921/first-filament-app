<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OcrTaskResource\Pages;
use App\Models\OcrTask;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OcrTaskResource extends Resource
{
    protected static ?string $model = OcrTask::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'slug';

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-document-magnifying-glass';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'AI Tools';
    }

    public static function getNavigationLabel(): string
    {
        return 'OCR';
    }

    public static function getModelLabel(): string
    {
        return 'OCR Task';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::query()
            ->where('user_id', Auth::id())
            ->where(fn (Builder $query): Builder => $query
                ->where('status', 'queued')
                ->orWhere('status', 'processing'))
            ->count() ?: null;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function canView(Model $record): bool
    {
        return (int) $record->user_id === (int) Auth::id();
    }

    public static function canEdit(Model $record): bool
    {
        return (int) $record->user_id === (int) Auth::id();
    }

    public static function canDelete(Model $record): bool
    {
        return (int) $record->user_id === (int) Auth::id();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('OCR Submission')
                ->description('Upload an image to extract its text using the Flask AI service.')
                ->schema([
                    TextInput::make('title')
                        ->required()
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
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Notes / Description')
                        ->rows(4)
                        ->placeholder('Optional notes about this image...')
                        ->columnSpanFull(),
                ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->size(48),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed'  => 'success',
                        'processing' => 'info',
                        'queued'     => 'warning',
                        'failed'     => 'danger',
                        default      => 'gray',
                    }),

                TextColumn::make('user.name')
                    ->label('Submitted By')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('processed_at')
                    ->dateTime()
                    ->timezone(config('app.display_timezone', 'Asia/Karachi'))
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->timezone(config('app.display_timezone', 'Asia/Karachi'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options([
                    'queued'     => 'Queued',
                    'processing' => 'Processing',
                    'completed'  => 'Completed',
                    'failed'     => 'Failed',
                ]),
            ])
            ->actions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No OCR tasks yet')
            ->emptyStateDescription('Submit an image to extract its text via the Flask AI service.')
            ->emptyStateIcon('heroicon-o-document-magnifying-glass');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOcrTasks::route('/'),
            'create' => Pages\CreateOcrTask::route('/create'),
            'view'   => Pages\ViewOcrTask::route('/{record}'),
            'edit'   => Pages\EditOcrTask::route('/{record}/edit'),
        ];
    }
}
