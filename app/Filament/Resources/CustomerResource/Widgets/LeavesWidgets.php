<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;

class LeavesWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Annual Leave', Customer::count()),
            Card::make('Sick Leave', Customer::count()),
            Card::make('Hospitalisation Leave', Customer::count()),
            Card::make('Paternity Leave', Customer::count()),
            Card::make('Compassionate Leave', Customer::count()),
        ];
    }

    // public static function canView(): bool
    // {
    //     return auth()->user()->is_admin;
    // }
}
