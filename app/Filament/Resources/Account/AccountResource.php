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

class AccountResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    // protected static ?string $navigationLabel = 'Setting';
    public static ?string $slug = 'account';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make([
                'default' => 1
            ])->schema([
                // Forms\Components\TextInput::make('id')->disabled()->label('id'),
                Forms\Components\TextInput::make('userid')->label('User Id'),
                Forms\Components\TextInput::make('email')->label('Email'),
                Forms\Components\TextInput::make('name')->label('Name'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->confirmed()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                TextInput::make('password_confirmation')
                    ->label('Comfirm Password')
                    ->password()
                    ->required()
                    ->dehydrated(false),
            ])
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
