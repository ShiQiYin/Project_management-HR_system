<?php

namespace App\Filament\Resources\Customer\Pages;

use App\Filament\Resources\Customer\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;
    protected static string $view = 'filament::resources.customer-resource.pages.list-records';
    protected static bool $shouldRegisterNavigation = false;


    public function isTableSearchable(): bool
    {
        return true;
    }
    
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
