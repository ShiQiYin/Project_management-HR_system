<?php

namespace App\Filament\Resources\Leave\Pages;

use App\Filament\Resources\Leave\LeaveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\EditAction;

class EditLeave extends EditRecord
{
    protected static string $resource = LeaveResource::class;

    // This is to override the default view
    protected static string $view = 'filament::resources.leave-resource.pages.edit-record';

    protected static ?string $modelLabel = 'Leave';

    protected function getActions(): array
    {
        return [
            // EditAction::make()
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        if ($this->record['status'] == 'pending' )
            return [
                // EditAction::make(),
                // Actions\EditAction::make(),
                $this->record['status'] == 'pending' ? Action::make('Retract')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action('retract') : Action::make('Reopen')
                    ->requiresConfirmation()
                    ->action('reopen')
            ];

        return [];
        // return array_merge(parent::getFormActions(), [
        //     Action::make('close')->action('saveAndClose'),
        // ]);
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

    public function retract(array $data): void
    {
                           // $this->record->author()->associate($data['authorId']);
        DB::table('leaves_type')
            ->where('user_id', auth()->user()->id)
            ->incrementEach([
                'al' =>  $this->record['category'] == "al" ? $this->record['days'] : 0,
                'sl' =>  $this->record['category'] == "sl" ? $this->record['days'] : 0,
                'hl' =>  $this->record['category'] == 'hl' ? $this->record['days'] : 0,
                'pl' =>  $this->record['category'] == "pl" ? $this->record['days'] : 0,
                'cl' =>  $this->record['category'] == "cl" ? $this->record['days'] : 0,
            ]);

        $this->record['status'] = 'canceled';
        $this->record['user_id'] = auth()->user()->id;
        $this->record['updated_at'] = Carbon::now()->toDateTimeString();   
        $this->record->save();
    }

    public function reopen(array $data): void
    {
                           // $this->record->author()->associate($data['authorId']);
        DB::table('leaves_type')
            ->where('user_id', auth()->user()->id)
            ->decrementEach([
                'al' =>  $this->record['category'] == "al" ? $this->record['days'] : 0,
                'sl' =>  $this->record['category'] == "sl" ? $this->record['days'] : 0,
                'hl' =>  $this->record['category'] == 'hl' ? $this->record['days'] : 0,
                'pl' =>  $this->record['category'] == "pl" ? $this->record['days'] : 0,
                'cl' =>  $this->record['category'] == "cl" ? $this->record['days'] : 0,
            ]);

        $this->record['status'] = 'pending';
        $this->record['user_id'] = auth()->user()->id;
        $this->record['updated_at'] = Carbon::now()->toDateTimeString();   
        $this->record->save();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
