<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-tag';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Shop';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Product Images')
                ->description('Upload one or more product photos')
                ->schema([
                    FileUpload::make('images')
                        ->label('Product Images')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->directory('products')
                        ->disk('public')
                        ->maxFiles(10)
                        ->maxSize(4096)
                        ->columnSpanFull(),
                ]),

            Section::make('Product Information')
                ->description('Basic product details')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    TextInput::make('sku')
                        ->label('SKU')
                        ->unique(ignoreRecord: true)
                        ->maxLength(100),

                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->minValue(0),

                    TextInput::make('stock')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->default(0),

                    RichEditor::make('short_description')
                        ->label('Short Description')
                        ->helperText('A brief summary shown in product listings.')
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'textColor',
                            'bulletList',
                            'orderedList',
                            'link',
                        ])
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Product Details')
                ->description('Full product description — use headings (H1–H4) for different font sizes')
                ->schema([
                    RichEditor::make('long_description')
                        ->label('Long Description')
                        ->toolbarButtons([
                            'h2',
                            'h3',
                            'h4',
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'textColor',
                            'bulletList',
                            'orderedList',
                            'blockquote',
                            'link',
                            'attachFiles',
                            'undo',
                            'redo',
                        ])
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('products/attachments')
                        ->columnSpanFull(),
                ]),

            Section::make('Categorisation')
                ->description('Assign brand and category')
                ->schema([
                    Select::make('brand_id')
                        ->label('Brand')
                        ->relationship('brand', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                            TextInput::make('slug')
                                ->required()
                                ->unique('brands', 'slug')
                                ->maxLength(255),
                            TextInput::make('website')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://example.com'),
                            Textarea::make('description')
                                ->rows(2)
                                ->columnSpanFull(),
                            Toggle::make('is_active')
                                ->label('Active')
                                ->default(true),
                        ])
                        ->createOptionUsing(function (array $data) {
                            return \App\Models\Brand::create($data)->id;
                        }),

                    Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name', fn ($query) => $query->where('type', 'shop'))
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                            TextInput::make('slug')
                                ->required()
                                ->unique('categories', 'slug')
                                ->maxLength(255),
                            Textarea::make('description')
                                ->rows(2)
                                ->columnSpanFull(),
                            Toggle::make('is_active')
                                ->label('Active')
                                ->default(true),
                        ])
                        ->createOptionUsing(function (array $data) {
                            $data['type'] = 'shop';
                            return \App\Models\Category::create($data)->id;
                        }),
                ])->columns(2),

            Section::make('Visibility')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Toggle::make('is_featured')
                        ->label('Featured'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('')
                    ->disk('public')
                    ->getStateUsing(fn ($record) => collect($record->images ?? [])->first())
                    ->width(56)
                    ->height(56)
                    ->defaultImageUrl('https://placehold.co/56x56?text=📦')
                    ->extraImgAttributes(['style' => 'object-fit:contain;border-radius:4px;']),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
                    ->limit(45),

                TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('stock')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('brand')
                    ->relationship('brand', 'name'),
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                TernaryFilter::make('is_active')->label('Active'),
                TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Action::make('view_frontend')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record): string => url('/products/' . $record->slug))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make()
                    ->after(function ($record) {
                        \Filament\Notifications\Notification::make()
                            ->title('Product Deleted 🗑️')
                            ->body("Product '{$record->name}' deleted.")
                            ->danger()
                            ->sendToDatabase(auth()->user());
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No products yet')
            ->emptyStateDescription('Add your first product to get started.')
            ->emptyStateIcon('heroicon-o-tag');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
