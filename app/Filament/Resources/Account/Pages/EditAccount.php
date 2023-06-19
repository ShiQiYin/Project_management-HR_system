<?php

namespace App\Filament\Resources\Account\Pages;

use App\Filament\Resources\Account\AccountResource;
use App\Filament\Resources\PositionResource\PositionResource;
use App\Providers\RouteServiceProvider;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Actions\Action;
use App\Models\User;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    // This is to override the default view
    protected static string $view = 'filament::resources.customer-resource.pages.edit-record';

    protected static ?string $modelLabel = 'User';

    protected static ?string $title = 'Account Management';

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $data['isAdmin'] = $data['userid'] === 'admin';
    //     // $data['approval'] =  auth()->user()->id;
    //     // return [];
    //     return $data;
    // }
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];    }

    protected function beforeFill()
    {
        Notification::make()
        ->warning()
        ->title('You don\'t have any records for positions')
        ->body('Create at least one record to continue.')
        ->persistent()
        ->actions([
            NotificationAction::make('createPositions')
                ->button()
                ->url(PositionResource::getUrl('create'), shouldOpenInNewTab: false),
        ])
        ->send();
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

    public function editAccount(array $data): void
    {

        // $user = User::findBy;
        // $user->assignRole($this->record["roles"]);

        // $this->record['status'] = 'canceled';
        // $this->record['user_id'] = auth()->user()->id;
        // $this->record['updated_at'] = Carbon::now()->toDateTimeString();   
        // $this->record->save();


        // DB::table('users')->insert(
        //     $leaves
        // );
    }
}
