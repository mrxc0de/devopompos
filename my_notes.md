mv resources/views/vendor/Chatify resources/views/vendor/chatify

////
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskLinkResource\Pages;
use App\Filament\Resources\TaskLinkResource\RelationManagers;
use App\Models\TaskLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskLinkResource extends Resource
{
    protected static ?string $model = TaskLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Title'),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->label('URL'),
                Forms\Components\Select::make('status')
                    ->options(\App\TaskLinkStatus::statuses()->pluck('label', 'id'))
                    ->default('pending')
                    ->label('Status'),
                Forms\Components\Select::make('added_by')
                    ->relationship('user', 'name') // assuming relation name is "user" and you want to display user name
                    ->required()
                    ->label('Added By'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Title'),
                Tables\Columns\TextColumn::make('url')
                    ->url(fn($record) => $record->url)
                    ->label('URL'),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn(string $state) => \App\TaskLinkStatus::statuses()->pluck('label', 'id')->toArray()[$state] ?? $state)
                    ->label('Status'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Added By'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At'),
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
            'index' => Pages\ListTaskLinks::route('/'),
            'create' => Pages\CreateTaskLink::route('/create'),
            'edit' => Pages\EditTaskLink::route('/{record}/edit'),
        ];
    }
}
