<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('telegram_username')
                    ->label('Telegram Username')
                    ->nullable(),
                Forms\Components\TextInput::make('telegram_id')
                    ->label('Telegram ID')
                    ->nullable(),
                Forms\Components\Select::make('title')
                    ->label('Title')
                    ->options([
                        'Junior Laravel Developer' => 'Junior Laravel Developer',
                        'Mid Laravel Developer' => 'Mid Laravel Developer',
                        'Senior Laravel Developer' => 'Senior Laravel Developer',
                        'Junior React Developer' => 'Junior React Developer',
                        'Mid React Developer' => 'Mid React Developer',
                        'Senior React Developer' => 'Senior React Developer',
                        'Fullstack Developer' => 'Fullstack Developer',
                        'DevOps Engineer' => 'DevOps Engineer',
                        'QA Engineer' => 'QA Engineer',
                    ])
                    ->searchable()
                    ->nullable(),
                // Forms\Components\DateTimePicker::make('email_verified_at')
                //     ->label('Email Verified At')
                //     ->nullable()
                //     ->dehydrated(true)
                //     ->default(fn($record) => $record?->email_verified_at),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null) // only hash if filled
                    ->dehydrated(fn($state) => filled($state)) // prevent updating if empty
                    ->required(fn(Page $livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->maxLength(255)
                    ->autocomplete('new-password')
                    ->nullable(),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telegram_username')
                    ->label('Telegram Username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telegram_id')
                    ->label('Telegram ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Email Verified At')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->formatStateUsing(fn($state, $record) => $record->getRoleNames()->join(', '))
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
