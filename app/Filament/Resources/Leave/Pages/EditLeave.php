<?php

namespace App\Filament\Resources\Leave\Pages;

use App\Filament\Resources\Leave\LeaveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeave extends EditRecord
{
    protected static string $resource = LeaveResource::class;

    // This is to override the default view
    protected static string $view = 'filament::resources.leave-resource.pages.edit-record';

    protected static ?string $modelLabel = 'Leave';

    protected function getActions(): array
    {
        return [
            // Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    protected function beforeFill()
    {
        // Runs before the form fields are populated with their default values.
    }

    protected function afterFill()
    {
        // Runs after the form fields are populated with their default values.
    }

    protected function beforeValidate()
    {
        // Runs before the form fields are validated when the form is submitted.
    }

    protected function afterValidate()
    {
        // Runs after the form fields are validated when the form is submitted.
    }

    protected function beforeCreate()
    {
        // Runs before the form fields are saved to the database.
    }

    protected function afterCreate()
    {
        // Runs after the form fields are saved to the database.
    }
}
