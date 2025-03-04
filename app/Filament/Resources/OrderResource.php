<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Models\OrderItem;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelOrderItem = OrderItem::class;

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $navigationGroup = 'Shopping';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([

                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user','name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('product_id')
                            ->label('Product')
                            ->relationship('product','name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        ToggleButtons::make('status')
                            ->required()
                            ->inline()
                            ->default('pending')
                            ->label('Order Status')
                            ->options([
                                'pending' => 'Pending',
                                'settlement' => 'Settlement',
                                'failed' => 'Failed',
                            ])
                            ->colors([
                                'pending' => 'info',
                                'settlement' => 'success',
                                'failed' => 'danger',
                            ])
                            ->icons([
                                'pending' => 'heroicon-m-arrow-path',
                                'success' => 'heroicon-m-check',
                                'failed' => 'heroicon-m-x-circle',
                            ]),


                        Textarea::make('notes')
                            ->columnSpanFull()
                    ])->columns(2),

                    Section::make('Order Items')->schema([
                        Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Select::make('product_id')
                                ->relationship('product','name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->columnSpan(4)
                                ->reactive()
                                ->afterStateUpdated(fn($state, Set $set) => $set('unit_amount', Product::find($state) ?->price ?? 0))
                                ->afterStateUpdated(fn($state, Set $set) => $set('total_amount', Product::find($state) ?->price ?? 0)),

                            TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->disabled()
                                ->columnSpan(2),
                                // ->reactive()
                                // ->afterstateupdated(fn($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount'))),

                            TextInput::make('unit_amount')
                                ->required()
                                ->numeric()
                                ->disabled()
                                ->dehydrated()
                                ->columnSpan(3),

                            TextInput::make('total_amount')
                                ->numeric()
                                ->required()
                                ->dehydrated()
                                ->columnSpan(3),
                ])->columns(12),

                Placeholder::make('grand_total_placeholder')
                ->label('Grand Total')
                ->content(function(Get $get, Set $set){
                    $total = 0;
                    if(!$repeaters = $get('items')){
                        return $total;
                    }

                    foreach($repeaters as $key => $repeater){
                        $total += $get('items.'.$key.'.total_amount');
                    }
                    $set('grand_total', $total);
                    return Number::currency($total, 'IDR');
                }),

                Hidden::make('grand_total')
                    ->default(0)
            ])
            ])->columnSpanFull()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('user.name')
                ->label('Customer')
                ->sortable()
                ->searchable(),

            TextColumn::make('items.product.name')
                ->label('Product')
                ->sortable()
                ->searchable()
                ->default('N/A'),

            TextColumn::make('grand_total')
                ->numeric()
                ->sortable()
                ->money('IDR'),

            TextColumn::make('notes')
                ->sortable()
                ->searchable(),

            SelectColumn::make('status')
                ->options([
                    'pending' => 'Pending',
                    'settlement' => 'Settlement',
                    'failed' => 'Failed'
                ])
                ->searchable()
                ->sortable(),

            // SelectColumn::make('order_status')
            //     ->options([
            //         'pending' => 'Pending',
            //         'success' => 'Success',
            //         'cancelled' => 'Cancelled'
            //     ])
            //     ->searchable()
            //     ->sortable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->label('Order Date')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
