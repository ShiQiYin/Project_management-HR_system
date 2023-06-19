<?php

namespace App\Filament\Resources\PendingLeave;

use Filament\Forms;
use App\Filament\Resources\PendingLeave\Pages;
use App\Filament\Resources\PendingLeaveResource\RelationManagers\ApprovalRelationManager;
use App\Filament\Resources\PendingLeaveResource\RelationManagers\UsersRelationManager;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
// use App\Filament\Resources\PendingLeaveResource\RelationManagers;

class PendingLeaveResource extends Resource
{
    protected static ?string $model = Leave::class;
    // protected static ?string $resource = DB::table('leave');
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationLabel = 'Leave Application(s)';

    public static ?string $slug = 'pendingleave';


    public function isTableSearchable(): bool
    {
        return true;
    }

    protected static function getNavigationBadge(): ?string
    {
        return DB::table('leaves')
        ->where('status', 'pending')
        ->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Status')->schema([


                Forms\Components\TextInput::make('status')->required()->label('Status')->hiddenOn('create')->disabledOn('edit'),
                Forms\Components\DatePicker::make('approved_date')->required()->label('Processed date')->displayFormat('d Mon, Yr (D)')->hiddenOn('create')->disabledOn('edit'),
                Select::make('approvals')
                    ->label('Processed by')
                    ->relationship('approvals', 'name')
                    ->disabledOn('edit')->hiddenOn('create'),
                // Select::make('status')
                // ->options([
                //     'reject' => 'reject',
                //     'approved' => 'approved',

                // ])
                // ->label("Status"),
                // Forms\Components\DatePicker::make('approved_date')->required()->label('Processed date')->hiddenOn('create')->disabledOn('edit'),
                // Forms\Components\TextInput::make('name')->required()->label('Processed by')->disabledOn('edit')->hiddenOn('create'),

            ])->hiddenOn('create'),
            Section::make('Request Leave')
            ->schema([
                Select::make('name')
                    ->label('Submmited by')
                    ->relationship('users', 'name')
                    ->disabledOn('edit')->hiddenOn('create'),
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
                Forms\Components\DatePicker::make('start_date')->disabled()->reactive()->required()->minDate('today')->displayFormat('d Mon, Yr (D)')->label('Start Date'),
                Forms\Components\DatePicker::make('end_date')->disabled()
                    ->required()
                    ->displayFormat('d Mon, Yr (D)')
                    ->minDate('start_date')
                    ->afterOrEqual('start_date')
                    ->label('End Date')
                    ->displayFormat('d Mon, Yr (D)')
                    ->reactive(),
                Forms\Components\TextInput::make('days')->disabled()->label('Day(s)'),
                Forms\Components\TextInput::make('reason')->required()->label('Reason')->disabled(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')->disabled()->label('Submitted by')->sortable()
                ->searchable(),
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
                Tables\Columns\TextColumn::make('start_date')->label('Start Date')
                ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_date')->label('End Date')->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('days')->label('day(s)')->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Reason')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                    'primary',
                    'secondary' => static fn ($state): bool => $state === 'canceled',
                    'warning' => static fn ($state): bool => $state === 'pending',
                    'success' => static fn ($state): bool => $state === 'approved',
                    'danger' => static fn ($state): bool => $state === 'rejected',
                ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('approved_date')
                    ->label('Processed date'),
                Tables\Columns\TextColumn::make('approvals.name')
                    ->label('Processed by'),
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
            UsersRelationManager::class,
            ApprovalRelationManager::class,
            // RelationManagers\UsersRelationManager::class,
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

    protected function getTableActions(): array
    {
        return [
            // ...
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->select('leaves.*', 'u.name as name', 'a.name as approval')
    //         ->where('status', '<>', 'canceled')
    //         ->join('users as u','leaves.user_id' ,'u.id')
    //         ->leftJoin('users as a','leaves.approval','=','a.id');;
    // }

    
}
