<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class DashboardChart extends ChartWidget
{
    protected static ?string $heading = 'Order Chart';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '250px';
    protected static ?int $sort = 2;
    public ?string $filter = 'today';



    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = Trend::model(Order::class)
        ->between(
            start: now()->subMonth(6),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        // dd($data);

        return [
            'datasets' => [
                [
                    'label' => 'Order Created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    // 'backgroundColor' => '#36A2EB',
                    // 'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
