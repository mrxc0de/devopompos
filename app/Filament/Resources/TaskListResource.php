<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskListResource\Pages;
use App\Filament\Resources\TaskListResource\RelationManagers;
use App\Models\TaskList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskListResource extends Resource
{
    protected static ?string $model = TaskList::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    // protected static ?string $navigationGroup = 'Tasks';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('description')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Select::make('assigned_to')
                    ->label('Assigned To')
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\Select::make('added_by')
                    ->label('Added By')
                    ->relationship('creator', 'name', function ($query) {
                        $query->whereHas('roles', function ($q) {
                            $q->whereIn('name', ['super_admin', 'Team Lead']);
                        });
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->default('low')
                    ->required(),
                Forms\Components\DateTimePicker::make('due_date'),
                // Forms\Components\DateTimePicker::make('completed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assignee.name')
                    ->label('Assigned To')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Added By')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->disableOptionWhen(fn($state) => $state === 'completed')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state === 'completed' && is_null($record->completed_at)) {
                            $record->forceFill(['completed_at' => now()])->saveQuietly();
                        }
                    })
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'low' => 'gray',
                        'medium' => 'warning',
                        'high' => 'danger',
                    ]),
                Tables\Columns\TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTaskLists::route('/'),
            'create' => Pages\CreateTaskList::route('/create'),
            'edit' => Pages\EditTaskList::route('/{record}/edit'),
        ];
    }
}
