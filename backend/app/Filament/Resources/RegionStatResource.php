<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionStatResource\Pages;
use App\Models\RegionStat;
use Filament\Forms;
use Filament\Schemas\Schema; // UPDATED
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
 // UPDATED for Actions

class RegionStatResource extends Resource
{
    protected static ?string $model = RegionStat::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    public static function form(Schema $form): Schema // UPDATED
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('region_name')->required(),
                   Forms\Components\TextInput::make('branch_count')->numeric()->required(),
                   Forms\Components\TextInput::make('member_count_text')->required(),
                   Forms\Components\TextInput::make('status')->default('Aktif & Berkembang'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('region_name')->searchable(),
                    Tables\Columns\TextColumn::make('branch_count'),
                    Tables\Columns\TextColumn::make('member_count_text'),
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
            'index' => Pages\ListRegionStats::route('/'),
            'create' => Pages\CreateRegionStat::route('/create'),
            'edit' => Pages\EditRegionStat::route('/{record}/edit'),
        ];
    }
}
