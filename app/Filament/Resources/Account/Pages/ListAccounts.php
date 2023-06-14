<?php

namespace App\Filament\Resources\Account\Pages;

use App\Filament\Resources\Account\AccountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;
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
