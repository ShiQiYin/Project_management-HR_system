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
                Forms\Components\DatePicker::make('start_date')->reactive()->required()->minDate('today')->displayFormat('d/m/Y')->label('Start Date'),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->minDate('start_date')
                    ->afterOrEqual('start_date')
                    ->label('End Date')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $get, $state) {
                        $set('days',  Carbon::parse($get('end_date'))->diffInDays(Carbon::parse($get('start_date'))) + 1 );
                    })    
                    ->afterStateHydrated(function (Closure $set, $get, $state) {
                        $set('days',  Carbon::parse($get('end_date'))->diffInDays(Carbon::parse($get('start_date'))) + 1 );
                    }),
                Forms\Components\TextInput::make('days')->disabled()->dehydrated(false)->label('Day(s)'),
                Forms\Components\TextInput::make('reason')->required()->label('Reason'),
                // Forms\Components\TextInput::make('user_id')->required()->label('User Id')->default(auth()->user()->id)->hidden(),

                FileUpload::make('attachment')
                    ->disk('local')
                    ->directory(`leave`)
                    ->preserveFilenames()
                    ->enableOpen()
                    ->enableDownload()
                    ->visibility('public')
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
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
