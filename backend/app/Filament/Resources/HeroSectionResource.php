<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Models\HeroSection;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Hero Section';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('party_name')
                    ->required()
                    ->default('Partai Ibu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('subtitle')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                \Filament\Schemas\Components\Fieldset::make('Statistics')
                    ->schema([
                        Forms\Components\TextInput::make('stat_members')
                            ->required()
                            ->default('50K+'),
                        Forms\Components\TextInput::make('stat_provinces')
                            ->required()
                            ->default('34'),
                        Forms\Components\TextInput::make('stat_programs')
                            ->required()
                            ->default('100+'),
                    ])->columns(3),
                Forms\Components\TextInput::make('primary_button_text')
                    ->required()
                    ->default('Daftar Sekarang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('secondary_button_text')
                    ->required()
                    ->default('Pelajari Lebih Lanjut')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->directory('hero-images')
                    ->visibility('public')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_button_text'),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}
