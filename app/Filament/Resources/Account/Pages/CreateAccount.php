<?php

namespace App\Filament\Resources\Account\Pages;

use App\Filament\Resources\Account\AccountResource;
use App\Filament\Resources\PermissionsResource\PermissionsResource;
use App\Filament\Resources\PositionResource\PositionResource;
use App\Models\Leave;
use App\Models\Position;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Actions\Action;
use App\Models\User;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;


class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;
    protected static string $view = 'filament::resources.customer-resource.pages.create-record';

    protected function getFormActions(): array
    {
        return [
            // EditAction::make(),
            // Actions\EditAction::make(),
            Action::make('Create')
                ->requiresConfirmation()
                ->action('createNewUser') 
        ];
        // return array_merge(parent::getFormActions(), [
        //     Action::make('close')->action('saveAndClose'),
        // ]);
    }

    protected function beforeFill()
    {
        // Runs before the form fields are populated with their default values.
        if ( Position::count() === 0) {
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
 
        }
        
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

    private function createUser($userid, $email, $name)
    {
        try
        {
            $user = User::factory()->create([
                'userid' => $userid,
                'email' => $email,
                'name' => $name
            ]);
        }
        catch (QueryException $e)
        {
            // User exists
            $user = User::where('userid', $userid)->first();
        }
        return $user;
    }

    public function createNewUser(array $data): void
    {

        $user = $this->createUser($this->record["userid"], $this->record["email"], $this->record["name"]);
        $user->assignRole('admin');

        $leaves = [
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
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
    }

    public function createPositions()
    {
        // Runs after the form fields are saved to the database.
    }


}
