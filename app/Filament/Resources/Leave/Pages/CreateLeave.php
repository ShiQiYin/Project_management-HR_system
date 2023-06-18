<?php

namespace App\Filament\Resources\Leave\Pages;

use App\Filament\Resources\Leave\LeaveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateLeave extends CreateRecord
{
    protected static string $resource = LeaveResource::class;
    protected static string $view = 'filament::resources.leave-resource.pages.create-record';

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make()->label('Apply Leave'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {        
        DB::table('leaves_type')
            ->where('user_id', auth()->user()->id)
            ->decrementEach([
                'al' =>  $data['category'] == "al" ? $data['days'] : 0,
                'sl' =>  $data['category'] == "sl" ? $data['days'] : 0,
                'hl' =>  $data['category'] == 'hl' ? $data['days'] : 0,
                'pl' =>  $data['category'] == "pl" ? $data['days'] : 0,
                'cl' =>  $data['category'] == "cl" ? $data['days'] : 0,

            ]);


        $data['user_id'] = auth()->user()->id;
        $data['updated_at'] = Carbon::now()->toDateTimeString();
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
        clock()->info("User logged in!");


        // Runs before the form fields are saved to the database.
    }

    protected function afterCreate()
    {
        $leaves = [
            // 'id' => Str::uuid()->toString(),
            // 'user_id' => $id,
            'al' => 12,
            'sl' => 12,
            'hl' => 60,
            'pl' => 14,
            'cl' => 3,
            'updated_at' => Carbon::now()->toDateTimeString()
        ];

        // DB::table('leaves_type')
        //     ->where('user_id', auth()->user()->id)
        //     ->decrement('al', 1);
        // Runs after the form fields are saved to the database.
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
