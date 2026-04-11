<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-bookmark-square';
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Shop';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Brand Logo')
                ->description('Upload a brand logo image')
                ->schema([
                    FileUpload::make('logo')
                        ->label('Logo')
                        ->image()
                        ->imageEditor()
                        ->directory('brands')
                        ->disk('public')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                ]),

            Section::make('Brand Details')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('website')
                    ->url()
                    ->maxLength(255)
                    ->placeholder('https://example.com'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),
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

                TextColumn::make('website')
                    ->searchable()
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab()
                    ->color('primary'),

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
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No brands yet')
            ->emptyStateDescription('Create your first brand to get started.')
            ->emptyStateIcon('heroicon-o-bookmark-square');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit'   => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
