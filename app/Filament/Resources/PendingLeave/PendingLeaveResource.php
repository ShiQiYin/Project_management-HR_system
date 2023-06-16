<?php

namespace App\Filament\Resources\PendingLeave;

use Filament\Forms;
use App\Filament\Resources\PendingLeave\Pages;
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
use Closure;
use Carbon\Carbon;

class PendingLeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Pending Leaves';

    public static ?string $slug = 'pendingleave';


    public function isTableSearchable(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Request Leave')
            ->schema([
                Forms\Components\TextInput::make('user_id')->disabled()->label('user_id'),
                Select::make('category')
                ->options([
                    'al' => 'Annual',
                    'sl' => 'Sick',
                    'hl' => 'Hospitalisation',
                    'pl' => 'Paternity',
                    'cl' => 'Compassionate leave',
                ])
                ->disabled()
                ->label("Leave Type"),
                Forms\Components\DatePicker::make('start_date')->disabled()->reactive()->required()->minDate('today')->displayFormat('d/m/Y')->label('Start Date'),
                Forms\Components\DatePicker::make('end_date')->disabled()
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->minDate('start_date')
                    ->afterOrEqual('start_date')
                    ->label('End Date')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $get, $state) {
                        $set('days',  Carbon::parse($get('end_date'))->diffInDays(Carbon::parse($get('start_date'))) );
                    })    
                    ->afterStateHydrated(function (Closure $set, $get, $state) {
                        $set('days',  Carbon::parse($get('end_date'))->diffInDays(Carbon::parse($get('start_date'))) );
                    }),
                Forms\Components\TextInput::make('days')->disabled()->dehydrated(false)->label('Day(s)'),
                Forms\Components\TextInput::make('reason')->required()->label('Reason')->disabled(),
                Select::make('status')
                ->options([
                    'reject' => 'reject',
                    'approved' => 'approved',

                ])
                ->label("Status"),
            // ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('user_id'),
                Tables\Columns\TextColumn::make('category')->label('category'),
                Tables\Columns\TextColumn::make('start_date')->label('Start Date'),
                Tables\Columns\TextColumn::make('end_date')->label('End Date'),
                Tables\Columns\TextColumn::make('reason')->label('Reason'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->extraAttributes(function (Leave $record) { 
                        if ($record->status === "pending") {
                            return ['class' => 'bg-warning-500'];
                        }
                        if ($record->status === "approved") {
                            return ['class' => 'bg-success-500'];
                        }
                        if ($record->status === "reject") {
                            return ['class' => 'bg-danger-500'];
                        }
                        return [];
                    }),
            ])
            ->filters([
                // Filter::make('individuals', fn ($query) => $query->where('type', 'individual')),
                // Filter::make('organizations', fn ($query) => $query->where('type', 'organization')),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPendingLeaves::route('/'),
            'create' => Pages\CreatePendingLeave::route('/create'),
            'edit' => Pages\EditPendingLeave::route('/{record}/edit'),
        ];
    }
}
