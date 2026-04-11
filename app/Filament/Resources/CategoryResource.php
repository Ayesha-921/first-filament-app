<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-tag';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Shop';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Category Image')
                ->description('Upload a category banner or icon')
                ->schema([
                    FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->imageEditor()
                        ->directory('categories')
                        ->disk('public')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                ]),

            Section::make('Category Details')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('type')
                    ->options(['shop' => 'Shop', 'blog' => 'Blog'])
                    ->required()
                    ->default('shop'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),
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

                TextColumn::make('slug')
                    ->searchable()
                    ->color('gray'),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'shop' => 'warning',
                        'blog' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->badge()
                    ->color('warning'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')->options(['shop' => 'Shop', 'blog' => 'Blog']),
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No categories yet')
            ->emptyStateDescription('Create your first category to get started.')
            ->emptyStateIcon('heroicon-o-tag');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
