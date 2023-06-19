<?php

namespace App\Filament\Resources\Account;

use App\Filament\Resources\Account\Pages;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Hash;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;

class AccountResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    // protected static ?string $navigationLabel = 'Setting';
    public static ?string $slug = 'account';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make([
                'default' => 1
            ])->schema([
                Section::make('User Information')->schema([

                Forms\Components\TextInput::make('userid')
                    ->required()
                    ->label('User Id')
                    ->rules(['required', 'min:1'])
                    ->disabledOn("edit")->unique(ignoreRecord:true),
                Forms\Components\TextInput::make('email')
                    ->label('Email'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Name'),
                TextInput::make('password')
                    ->helperText("Default password is 'password'")
                    ->label('Password')
                    ->default("password")
                    ->password()
                    ->required()
                    ->disabled()
                    ->hiddenOn('edit')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                ]),

                Section::make('Organization')->schema([

                    Select::make('position')
                    ->required()
                    ->relationship('positions', 'name')
                ]),


                Section::make('Security Matrix')->schema([

                    Select::make('roles')
                    ->multiple()
                    ->required()
                    ->relationship('roles', 'name')
                    ->preload()


                ]),
    
            ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')->label('id'),
                Tables\Columns\TextColumn::make('userid')->label('User Id'),
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('positions.name')->label('Position'),
                Tables\Columns\TextColumn::make('roles.name')->label('Roles'),
            ])
            ->filters([
            ])
            ->actions([
            ])
            ->bulkActions([
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }

}
