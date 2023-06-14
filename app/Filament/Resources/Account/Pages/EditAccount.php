<?php

namespace App\Filament\Resources\Account\Pages;

use App\Filament\Resources\Account\AccountResource;
use App\Providers\RouteServiceProvider;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    // This is to override the default view
    protected static string $view = 'filament::resources.customer-resource.pages.edit-record';

    protected static ?string $modelLabel = 'User';

    protected static ?string $title = 'Account Management';

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];    }

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

    protected function getRedirectUrl(): string
    {
        return RouteServiceProvider::LOGIN;
    }
}
