<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Schemas\Schema; // UPDATED
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
 // UPDATED for Actions

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-photo';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    public static function form(Schema $form): Schema // UPDATED
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                   Forms\Components\Textarea::make('caption'),
                   Forms\Components\FileUpload::make('image')->directory('gallery')->image()->required(),
                   Forms\Components\TextInput::make('category'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\ImageColumn::make('image'),
                    Tables\Columns\TextColumn::make('category'),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(), // UPDATED
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([ // UPDATED
                    \Filament\Actions\DeleteBulkAction::make(), // UPDATED
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
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
