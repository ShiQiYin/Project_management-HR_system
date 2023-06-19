<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class LeavesChart extends LineChartWidget
{

    protected int | string | array $columnSpan = 'full';


    protected function getHeading(): string
    {
        return 'Leave posts';
    }
 
    protected function getData(): array
    {
		$data = Trend::model(Leave::class)
			->between(
				start: now()->startOfYear(),
				end: now()->endOfYear(),
			)
			->perMonth()
			->count();
		
        return [
            'datasets' => [
                [
                    'label' => 'Leaves Application(s)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
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

    public static function canView(): bool
    {
        $user = auth()->user();

        return $user->can('admin-dashboard');
    }
}
