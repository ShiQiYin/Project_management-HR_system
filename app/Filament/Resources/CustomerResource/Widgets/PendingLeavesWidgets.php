<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use App\Models\LeaveType;
use Illuminate\Support\Facades\DB;

class PendingLeavesWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            // Q: get the count of each leave type
            Card::make('Pending Leave', 
                DB::table('leaves')
                    ->where('status', 'pending')
                    ->count()),
        ];
    }

    // public static function canView(): bool
    // {
    //     return auth()->user()->is_admin;
    // }
}
