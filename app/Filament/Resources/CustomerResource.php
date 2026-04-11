<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
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

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
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
        return 'info';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Customer Information')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(50),

                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->required()
                    ->default('active'),

                TextInput::make('city')
                    ->maxLength(100),

                TextInput::make('country')
                    ->maxLength(100),
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

                TextColumn::make('phone')
                    ->searchable(),

                TextColumn::make('city')
                    ->searchable(),

                TextColumn::make('country')
                    ->searchable(),

                TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Orders')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active'   => 'success',
                        'inactive' => 'danger',
                        default    => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive']),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No customers yet')
            ->emptyStateDescription('Add your first customer to get started.')
            ->emptyStateIcon('heroicon-o-user-group');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit'   => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
