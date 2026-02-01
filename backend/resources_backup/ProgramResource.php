<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Schemas\Schema; // UPDATED
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions; // UPDATED for Actions

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Content';

    public static function form(Schema $form): Schema // UPDATED
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\Textarea::make('description')->required(),
                   Forms\Components\FileUpload::make('icon')->directory('programs'),
                   Forms\Components\TextInput::make('stats_text'),
                   Forms\Components\TextInput::make('action_text')->default('Pelajari Lebih Lanjut'),
                   Forms\Components\TextInput::make('action_url'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\TextColumn::make('stats_text'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(), // UPDATED
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([ // UPDATED
                    Actions\DeleteBulkAction::make(), // UPDATED
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
