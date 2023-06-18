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

                Forms\Components\TextInput::make('userid')->required()->label('User Id')->rules(['required', 'min:1'])->disabledOn("edit")->unique(ignoreRecord:true),
                Forms\Components\TextInput::make('email')->label('Email'),
                Forms\Components\TextInput::make('name')->required()->label('Name'),
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
                Tables\Columns\TextColumn::make('permission_group')->label('Permission Group')
                // ->default()
                ->description(function (User $record) {
                    return "";
                    $text = DB::table('roles')
                        ->select('name')->where('id', $record->role_id)->get()->pluck('name')[0];

                    return $text;
                }),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select('users.*', 'm.*')
            ->leftJoin('model_has_roles as m','m.model_uuid' ,'id')
            ->leftJoin('role_has_permissions as r_p', 'r_p.role_id', 'm.role_id')
            ->distinct();
            // ->unique('userid');
            // ->join('roles as r', 'r.id', 'r_p.role_id');
    }
}
