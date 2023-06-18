<?php

namespace App\Filament\Resources\PermissionsResource\Pages;

use App\Filament\Resources\PermissionsResource\PermissionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionsResource::class;
    protected static string $view = 'filament::resources.leave-resource.pages.edit-record';

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
