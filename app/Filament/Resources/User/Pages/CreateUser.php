<?php

namespace App\Filament\Resources\User\Pages;

use App\Filament\Resources\User\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    // protected static string $view = 'filament::resources.user-resource.pages.create-record';

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
        $leaves = [
            'id' => Str::uuid()->toString(),
            'user_id' => $this->record['id'],
            'al' => 14,
            'sl' => 14,
            'hl' => 60,
            'pl' => 14,
            'cl' => 3,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
        DB::table('leaves_type')->insert(
            $leaves
        );

        // Runs after the form fields are saved to the database.
    }

}
