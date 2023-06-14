<?php

namespace App\Filament\Resources\User\Pages;

use App\Filament\Resources\User\UserResource;
use App\Providers\RouteServiceProvider;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    // This is to override the default view
    protected static string $view = 'filament::resources.user-resource.pages.edit-record';

    protected static ?string $modelLabel = 'User';

    protected static ?string $title = 'Update Personal Information';

    protected function getActions(): array
    {
        return [];
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

    protected function getRedirectUrl(): string
    {
        return RouteServiceProvider::LOGIN;
    }
}
