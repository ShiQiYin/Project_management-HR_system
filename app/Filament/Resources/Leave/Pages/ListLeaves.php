<?php

namespace App\Filament\Resources\Leave\Pages;

use App\Filament\Resources\CustomerResource\Widgets;
use App\Filament\Resources\Leave\LeaveResource;
use App\Filament\Resources\Leave\Widgets\LeaveOverview;
use App\Models\Leave;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerResource;

class ListLeaves extends ListRecords
{
    protected static string $resource = LeaveResource::class;
    protected static string $view = 'filament::resources.leave-resource.pages.list-records';
    protected static bool $shouldRegisterNavigation = false;


    public function isTableSearchable(): bool
    {
        return true;
    }
    
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerResource\Widgets\LeavesWidgets::class,
            // Widgets\PersonalCalendarWidget::class,
        ];
    }

    public function viewAny(): bool
    {
        return false;
    }

    public function view(): bool
    {
        return false;
    }


}
