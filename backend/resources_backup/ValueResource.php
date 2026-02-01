<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValueResource\Pages;
use App\Models\Value;
use Filament\Forms;
use Filament\Schemas\Schema; // UPDATED
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions; // UPDATED for Actions

class ValueResource extends Resource
{
    protected static ?string $model = Value::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationGroup = 'Content';

    public static function form(Schema $form): Schema // UPDATED
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\Textarea::make('description')->required(),
                   Forms\Components\FileUpload::make('icon')->directory('icons')->image(),
                   Forms\Components\TextInput::make('order')->numeric()->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\ImageColumn::make('icon'),
                    Tables\Columns\TextColumn::make('order')->sortable(),
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
            'index' => Pages\ListValues::route('/'),
            'create' => Pages\CreateValue::route('/create'),
            'edit' => Pages\EditValue::route('/{record}/edit'),
        ];
    }
}
