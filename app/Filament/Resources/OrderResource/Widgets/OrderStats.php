<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Orders', Order::query()->where('status', 'pending')->count()),
            Stat::make('Settlement Orders', Order::query()->where('status', 'settlement')->count()),
            Stat::make('Failed Orders', Order::query()->where('status', 'failed')->count()),
            Stat::make('Average Price', Number::currency(Order::query()->average('grand_total'), 'IDR')),
        ];
    }
}
