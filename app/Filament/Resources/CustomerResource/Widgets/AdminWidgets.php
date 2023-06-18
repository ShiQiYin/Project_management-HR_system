<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AdminWidgets extends BaseWidget
{


    protected function getCards(): array
    {
        $user = auth()->user();

        return [
            Card::make('Leave application submitted', 
                DB::table('leaves')
                    ->where('status', 'pending')
                    ->where('user_id', auth()->user()->id)
                    ->count()),
            $user->can('approved-leave') ? 
                Card::make('Pending Leave', 
                DB::table('leaves')
                    ->where('status', 'pending')
                    ->count()) : null,
            // Card::make('Customers Registered Today', Customer::whereDate('created_at', today())->count()),
            // Card::make('Tasks Created Today', Customer::whereDate('created_at', today())->count()),
        ];
    }

    // public static function canView(): bool
    // {
    //     return auth()->user()->is_admin;
    // }
}
