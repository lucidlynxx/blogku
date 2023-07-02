<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-alt';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')
                    ->label('Title')
                    ->relationship('post', 'title')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Name')
                    ->relationship('user', 'name')
                    ->required(),
                Grid::make(1)
                    ->schema([
                        Forms\Components\Textarea::make('comment')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name and Post title')
                    ->description(fn (Comment $record): string => $record->post->title)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('comment')
                    ->words(5)
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('visibility'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d M Y - H:i')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->date('d M Y - H:i')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageComments::route('/'),
        ];
    }
}
