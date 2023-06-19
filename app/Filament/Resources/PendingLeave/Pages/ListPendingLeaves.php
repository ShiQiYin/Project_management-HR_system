<?php

namespace App\Filament\Resources\PendingLeave\Pages;

use App\Filament\Resources\CustomerResource\Widgets;
use App\Filament\Resources\PendingLeave\PendingLeaveResource;
use App\Filament\Resources\Leave\Widgets\LeaveOverview;
use App\Models\Leave;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerResource;

class ListPendingLeaves extends ListRecords
{
    protected static string $resource = PendingLeaveResource::class;
    protected static string $view = 'filament::resources.pending-leave-resource.pages.list-records';
    protected static bool $shouldRegisterNavigation = false;


    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerResource\Widgets\PendingLeavesWidgets::class,
        ];
    }

}
