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
use Closure;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LeaveResource\RelationManagers;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Request Leave';


    public function isTableSearchable(): bool
    {
        return true;
    }

    // protected function getTableActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make()->label('Apply Leave'),
    //     ];
    // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Status')->schema([
                Forms\Components\TextInput::make('status')->label('Status')->hiddenOn('create')->disabledOn('edit'),
                Forms\Components\DatePicker::make('approved_date')->label('Processed date')->displayFormat('d Mon, Yr (D)')->hiddenOn('create')->disabledOn('edit'),
                Forms\Components\TextInput::make('name')->label('Processed by')->disabledOn('edit')->hiddenOn('create'),

            ])->hiddenOn('create'),
            Section::make('Leave Information')
            ->schema([
                Select::make('category')
                ->options([
                    'al' => 'Annual',
                    'sl' => 'Sick',
                    'hl' => 'Hospitalisation',
                    'pl' => 'Paternity',
                    'cl' => 'Compassionate leave',

                ])
                ->label("Leave Type")
                ->required()
                ->disabledOn('edit'),
                Forms\Components\DatePicker::make('start_date')->disabledOn('edit')->reactive()->required()->minDate('today')->displayFormat('d Mon, Yr (D)')->label('Start Date'),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->displayFormat('d Mon, Yr (D)')
                    ->minDate('start_date')
                    ->afterOrEqual('start_date')
                    ->label('End Date')
                    ->reactive()
                    ->disabledOn('edit')
                    ->afterStateUpdated(function (Closure $set, $get, $state) {
                        $set('days',  Carbon::parse($get('end_date'))->diffInDays(Carbon::parse($get('start_date'))) + 1 );
                    })    
                    ->afterStateHydrated(function (Closure $set, $get, $state) {
                        $set('days',  Carbon::parse($get('end_date'))->diffInDays(Carbon::parse($get('start_date'))) + 1 );
                    }),
                Forms\Components\TextInput::make('days')->disabled()->label('Day(s)'),
                Forms\Components\TextInput::make('reason')->required()->label('Reason')->disabledOn('edit'),

                // Forms\Components\TextInput::make('user_id')->required()->label('User Id')->default(auth()->user()->id)->hidden(),

                FileUpload::make('attachment')
                    ->disk('local')
                    ->directory(`leave`)
                    ->preserveFilenames()
                    ->enableOpen()
                    ->enableDownload()
                    ->visibility('public')
                    ->disabledOn('edit')
            // ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->label('category')
                    ->enum([
                        'al' => 'Annual',
                        'sl' => 'Sick',
                        'hl' => 'Hospitalisation',
                        'pl' => 'Paternity',
                        'cl' => 'Compassionate leave',
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')->label('Start Date'),
                Tables\Columns\TextColumn::make('end_date')->label('End Date'),
                Tables\Columns\TextColumn::make('days')->label('day(s)')->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('reason')->label('Reason'),
                BadgeColumn::make('status')
                ->colors([
                    'primary',
                    'secondary' => static fn ($state): bool => $state === 'canceled',
                    'warning' => static fn ($state): bool => $state === 'pending',
                    'success' => static fn ($state): bool => $state === 'approved',
                    'danger' => static fn ($state): bool => $state === 'rejected',
                ])->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('approved_date')->label('Processed date'),
                Tables\Columns\TextColumn::make('name')->label('Processed by'),
            ])
            ->filters([
                // Filter::make('individuals', fn ($query) => $query->where('type', 'individual')),
                // Filter::make('organizations', fn ($query) => $query->where('type', 'organization')),
            ])
            ->actions([
                // Tables\Actions\CreateAction::make()->label('Apply Leave'),
                // Actions\CreateAction::make()->label('Apply Leave'),

            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
            
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->leftJoin('users as u','approval','=','u.id')
            ->where('user_id', auth()->user()->id);
    }

}
