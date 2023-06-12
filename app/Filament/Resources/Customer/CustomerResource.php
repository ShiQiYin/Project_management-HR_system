<?php

namespace App\Filament\Resources\Customer;

use Filament\Forms;
use App\Filament\Resources\Customer\Pages;
use App\Models\Customer;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Grid;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Leaves';


    public function isTableSearchable(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
             Section::make('This is description section')
                    ->description('Description')
                    ->schema([
                        Radio::make('feedback')
                            ->label('Do you like this post?')
                            ->boolean()
                            ->disabled(),
                        Forms\Components\TextInput::make('name')->autofocus()->label('Name')-> disabled(),
                        Forms\Components\TextInput::make('name')->autofocus()->label('status')-> disabled(),

                    // ]),
                    ]),
            Grid::make([
                'sm' => 1,
                'xl' => 1,
            ])->schema([Tabs::make('Heading')::make('Heading')->tabs([
                    Tabs\Tab::make('Tab 1')
                        ->icon('heroicon-o-bell')
                        ->schema([
                            Section::make('Section 1')
                                ->description('Description')
                                ->schema([
                                    Forms\Components\TextInput::make('name')->autofocus()->required()->label('Name'),
                                    Forms\Components\TextInput::make('email')->email()->required()->label('Email'),
                                    Forms\Components\Select::make('type')
                                        ->placeholder('Select a type')
                                        ->required()
                                        ->options([
                                            'individual' => 'Individual',
                                            'organization' => 'Organization',
                                        ]),
                                    Forms\Components\DatePicker::make('birthday')->required()->displayFormat('d/m/Y')->label('Birthdate'),
                                    FileUpload::make('attachment')
                                        ->disk('local')
                                        ->directory('customer')
                                        ->preserveFilenames()
                                        ->enableOpen()
                                        ->enableDownload()
                                        ->visibility('public')
                                        // ->file('/download/test.pdf')
                                ]), // Number of columns in a
                        ]),
                        // Form::file('file_name'),
                        Tabs\Tab::make('Tab 2')
                            ->icon('heroicon-o-bell')
                            ->badge('39')
                            ->schema([
                                Radio::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'scheduled' => 'Scheduled',
                                    'published' => 'Published'
                                ])
                                ->descriptions([
                                    'draft' => 'Is not visible.',
                                    'scheduled' => 'Will be visible.',
                                    'published' => 'Is visible.'
                                ])
                            ]),
                        ])]) ,
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('type')->label('Type'),
                Tables\Columns\TextColumn::make('birthday')->label('Birthdate'),
                Tables\Columns\TextColumn::make('attachment')->label('Attachment'),
                Tables\Columns\TextColumn::make('created_at')->label('Created'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
