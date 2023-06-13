<?php

namespace App\Filament\Resources\Leave;

use Filament\Forms;
use App\Filament\Resources\Leave\Pages;
use App\Models\Leave;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;


class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Leaves';


    public function isTableSearchable(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Request Leave')
            ->schema([
                Select::make('category')
                ->options([
                    'al' => 'Annual',
                    'sl' => 'Sick',
                    'hl' => 'Hospitalisation',
                    'pl' => 'Paternity',
                    'cl' => 'Compassionate leave',

                ])
                ->label("Leave Type"),
                Forms\Components\DatePicker::make('start_date')->required()->displayFormat('d/m/Y')->label('Start Date'),
                Forms\Components\DatePicker::make('end_date')->required()->displayFormat('d/m/Y')->label('End Date'),
                Forms\Components\TextInput::make('reason')->required()->label('Reason'),
            // ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')->label('category'),
                Tables\Columns\TextColumn::make('start_date')->label('Start Date'),
                Tables\Columns\TextColumn::make('end_date')->label('End Date'),
                Tables\Columns\TextColumn::make('reason')->label('Reason'),
            ])
            ->filters([
                // Filter::make('individuals', fn ($query) => $query->where('type', 'individual')),
                // Filter::make('organizations', fn ($query) => $query->where('type', 'organization')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
