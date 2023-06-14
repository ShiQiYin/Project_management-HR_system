<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;

class AdminWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            // Card::make('Total Customers', Customer::count()),
            // Card::make('Customers Registered Today', Customer::whereDate('created_at', today())->count()),
            // Card::make('Tasks Created Today', Customer::whereDate('created_at', today())->count()),
        ];
    }

    // public static function canView(): bool
    // {
    //     return auth()->user()->is_admin;
    // }
}
