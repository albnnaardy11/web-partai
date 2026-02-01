<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Schemas\Schema; // UPDATED
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions; // UPDATED for Actions

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationGroup = 'Content';

    public static function form(Schema $form): Schema // UPDATED
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')->required()->unique(ignoreRecord: true),
                   Forms\Components\Textarea::make('value'),
                   Forms\Components\Select::make('type')->options(['text'=>'Text', 'image'=>'Image'])->default('text'),
                   Forms\Components\TextInput::make('group')->default('general'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->searchable(),
                    Tables\Columns\TextColumn::make('value')->limit(50),
                    Tables\Columns\TextColumn::make('group'),
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
