<?php

namespace App\Filament\Resources\PositionResource\Pages;

use App\Filament\Resources\PositionResource\PositionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPositions extends ListRecords
{
    protected static string $resource = PositionResource::class;
    protected static string $view = 'filament::resources.leave-resource.pages.list-records';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
