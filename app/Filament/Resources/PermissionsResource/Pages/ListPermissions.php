<?php

namespace App\Filament\Resources\PermissionsResource\Pages;

use App\Filament\Resources\PermissionsResource\PermissionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionsResource::class;
    protected static string $view = 'filament::resources.leave-resource.pages.list-records';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
