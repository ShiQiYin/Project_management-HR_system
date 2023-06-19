<?php

namespace App\Filament\Resources\PendingLeave\Pages;

use App\Filament\Resources\PendingLeave\PendingLeaveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\DB;

class EditPendingLeave extends EditRecord
{
    protected static string $resource = PendingLeaveResource::class;

    // This is to override the default view
    protected static string $view = 'filament::resources.leave-resource.pages.edit-record';

    protected static ?string $modelLabel = 'Leave';

    protected function getActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        $actions = [];

        if ($this->record['status'] == 'pending') {
            return [
                Action::make('Approve')
                    ->requiresConfirmation()
                    ->modalHeading('Approve leave')
                    ->modalSubheading('Are you sure you\'d like to approve these leave? This cannot be undone.')
                    ->modalButton('Yes, APPROVED!')
                    ->action('approve'),
                Action::make('Reject')
                    ->requiresConfirmation()
                    ->modalHeading('Reject leave')
                    ->modalSubheading('Are you sure you\'d like to reject these leave? This cannot be undone.')
                    ->modalButton('Yes, REJECT!')
                    ->action('reject')
                    ->color('danger'),
            ];
        }
        // return [
        //     // EditAction::make(),
        //     // Actions\EditAction::make(),

            
        //     $this->record['status'] == 'pending' ? Action::make('Approved')
        //         ->requiresConfirmation()
        //         ->action('retract'): ,

        //     $this->record['status'] == 'pending' && Action::make('Reject')
        //         ->requiresConfirmation()
        //         ->action('retract'),
        // ];

        return $actions;
        // return array_merge(parent::getFormActions(), [
        //     Action::make('close')->action('saveAndClose'),
        // ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['approved_date'] = Carbon::now();
        $data['approval'] =  auth()->user()->id;
        // return [];
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['approved_date'] = Carbon::now();
        $data['approval'] =  auth()->user()->id;
        $record->update($data);
    
        return $record;
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

    public function approve(array $data): void
    {
        $this->record['status'] = 'approved';
        $this->record['approved_date'] = Carbon::now();
        $this->record['approval'] =  auth()->user()->id;
        // $this->record['user_id'] = auth()->user()->id;
        // $this->record['updated_at'] = Carbon::now()->toDateTimeString();   
        $this->record->save();
    }

    public function reject(array $data): void
    {
        DB::table('leaves_type')
        ->where('user_id', $this->record['user_id'])
        ->incrementEach([
            'al' =>  $this->record['category'] == "al" ? $this->record['days'] : 0,
            'sl' =>  $this->record['category'] == "sl" ? $this->record['days'] : 0,
            'hl' =>  $this->record['category'] == 'hl' ? $this->record['days'] : 0,
            'pl' =>  $this->record['category'] == "pl" ? $this->record['days'] : 0,
            'cl' =>  $this->record['category'] == "cl" ? $this->record['days'] : 0,
        ]);

        $this->record['status'] = 'rejected';
        // $this->record['user_id'] = auth()->user()->id;
        $this->record['approved_date'] = Carbon::now();
        $this->record['approval'] =  auth()->user()->id;
        $this->record->save();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
