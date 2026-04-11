<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Blog';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Author Information')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->color('primary'),

                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->label('Posts')
                    ->badge()
                    ->color('info'),

                TextColumn::make('bio')
                    ->limit(60)
                    ->color('gray'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No authors yet')
            ->emptyStateDescription('Add your first author to get started.')
            ->emptyStateIcon('heroicon-o-users');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit'   => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
