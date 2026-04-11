<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-shopping-bag';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
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
        return $schema->components([
            Section::make('Order Details')->schema([
                TextInput::make('number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => 'ORD-' . strtoupper(uniqid()))
                    ->maxLength(100),

                Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0),

                Select::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'processing' => 'Processing',
                        'shipped'    => 'Shipped',
                        'delivered'  => 'Delivered',
                        'cancelled'  => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),

                Select::make('payment_status')
                    ->options([
                        'unpaid'   => 'Unpaid',
                        'paid'     => 'Paid',
                        'refunded' => 'Refunded',
                    ])
                    ->required()
                    ->default('unpaid'),

                TextInput::make('shipping_address')
                    ->maxLength(500),

                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(3),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'    => 'warning',
                        'processing' => 'info',
                        'shipped'    => 'primary',
                        'delivered'  => 'success',
                        'cancelled'  => 'danger',
                        default      => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid'     => 'success',
                        'unpaid'   => 'danger',
                        'refunded' => 'warning',
                        default    => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options([
                    'pending'    => 'Pending',
                    'processing' => 'Processing',
                    'shipped'    => 'Shipped',
                    'delivered'  => 'Delivered',
                    'cancelled'  => 'Cancelled',
                ]),
                SelectFilter::make('payment_status')->options([
                    'unpaid'   => 'Unpaid',
                    'paid'     => 'Paid',
                    'refunded' => 'Refunded',
                ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->emptyStateHeading('No orders yet')
            ->emptyStateDescription('Orders will appear here once customers start purchasing.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
