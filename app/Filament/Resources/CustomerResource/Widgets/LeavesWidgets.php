<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use App\Models\LeaveType;
use Illuminate\Support\Facades\DB;

class LeavesWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            // Q: get the count of each leave type
            Card::make('Annual Leave', 
                DB::table('leaves_type')
                    ->select('al')
                    ->where('user_id', auth()->user()->id)
                    ->get()->pluck('al')[0] ),
            Card::make('Sick Leave', DB::table('leaves_type')
                ->select('sl')->where('user_id', auth()->user()->id)->get()->pluck('sl')[0]),
            Card::make('Hospitalisation Leave', DB::table('leaves_type')
                ->select('hl')->where('user_id', auth()->user()->id)->get()->pluck('hl')[0]),
            Card::make('Paternity Leave', DB::table('leaves_type')
                ->select('pl')->where('user_id', auth()->user()->id)->get()->pluck('pl')[0]),
            Card::make('Compassionate Leave', DB::table('leaves_type')
                ->select('cl')->where('user_id', auth()->user()->id)->get()->pluck('cl')[0]),
        ];
    }

    // public static function canView(): bool
    // {
    //     return auth()->user()->is_admin;
    // }
}
