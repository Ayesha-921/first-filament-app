<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
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
            Section::make('Post Details')
                ->description('Write your post content')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Textarea::make('excerpt')
                        ->rows(2)
                        ->columnSpanFull(),

                    Textarea::make('content')
                        ->rows(8)
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Publishing')
                ->schema([
                    Select::make('author_id')
                        ->label('Author')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name', fn ($query) => $query->where('type', 'blog'))
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Select::make('status')
                        ->options([
                            'draft'     => 'Draft',
                            'published' => 'Published',
                            'archived'  => 'Archived',
                        ])
                        ->required()
                        ->default('draft'),

                    DateTimePicker::make('published_at')
                        ->label('Publish Date')
                        ->nullable(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft'     => 'warning',
                        'archived'  => 'gray',
                        default     => 'gray',
                    }),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options([
                    'draft'     => 'Draft',
                    'published' => 'Published',
                    'archived'  => 'Archived',
                ]),
                SelectFilter::make('author')->relationship('author', 'name'),
                SelectFilter::make('category')->relationship('category', 'name'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Write your first blog post to get started.')
            ->emptyStateIcon('heroicon-o-document-text');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
