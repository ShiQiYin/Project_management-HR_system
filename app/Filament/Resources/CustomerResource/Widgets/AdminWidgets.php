<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\LineChartWidget;

class AdminWidgets extends BaseWidget
{


    protected function getCards(): array
    {
        $user = auth()->user();

        return [
            Card::make('Total leave application', 
                Leave::where('user_id', auth()->user()->id)->get()->count()),
            Card::make('Leave application submitted', 
                Leave::where('status', 'pending')->where('user_id', auth()->user()->id)->get()->count()),
            $user->can('Leave Application(s)') ? 
                Card::make('Pending Leave', 
                    Leave::where('status', 'pending')->get()->count()
                ) : null,
            // Card::make('Customers Registered Today', Customer::whereDate('created_at', today())->count()),
            // Card::make('Tasks Created Today', Customer::whereDate('created_at', today())->count()),
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
