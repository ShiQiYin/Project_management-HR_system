<?php

namespace App\Filament\Resources\RolesResource\Pages;

use App\Filament\Resources\RolesResource\RolesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RolesResource::class;
    protected static string $view = 'filament::resources.leave-resource.pages.list-records';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
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
