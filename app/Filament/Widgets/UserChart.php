<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserChart extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static ?int $sort = 1;

    // protected ?string $heading = 'Analytics';

    // protected ?string $description = 'An overview of some analytics.';
    protected function getStats(): array
    {
        return [

            Stat::make('New Users', User::query()->count())
                ->description('New Users that have joined')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40])
                ->color('success'),

            Stat::make('New Order', Order::query()->count())
                ->description('Order that have been made')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40])
                ->color('success'),

            Stat::make('Omset', Number::currency(Order::query()->sum('grand_total'), 'IDR'))
                ->description('Sales turnover')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
