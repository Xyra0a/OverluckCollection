<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
        ->query(OrderResource::getEloquentQuery())
        ->defaultPaginationPageOption(5) //buat nampilin 5 record saja
        ->defaultSort('created_at', 'desc')
        ->columns([
            TextColumn::make('id')
                ->label('Order ID')
                ->searchable(),

            TextColumn::make('user.name')
                ->label('Customer')
                ->sortable()
                ->searchable(),

            TextColumn::make('grand_total')
                ->numeric()
                ->money('IDR'),

            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state) => match ($state) {
                    'pending' => 'info',
                    'settlement' => 'success',
                    'failed' => 'danger',
                })
                ->icon(fn (string $state) => match ($state) {
                    'pending' => 'heroicon-m-arrow-path',
                    'success' => 'heroicon-m-check',
                    'failed' => 'heroicon-m-x-circle',
                })
                ->sortable(),

            TextColumn::make('payment_type')
                ->sortable()
                ->searchable(),

            // TextColumn::make('payment_status')
            //     ->sortable()
            //     ->badge()
            //     ->searchable(),

            TextColumn::make('created_at')
                ->label('Order Date')
                ->dateTime()
        ])

        ->actions([
            Action::make('View Order')
                ->url(fn (Order $order) => OrderResource::getUrl('view', ['record' => $order]))
                ->icon('heroicon-m-eye')
        ])
        ;
    }
}
