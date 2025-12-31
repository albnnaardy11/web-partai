<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'About Section';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Fieldset::make('Header Section')
                    ->schema([
                        Forms\Components\TextInput::make('header_badge')
                            ->required()
                            ->default('Tentang Kami'),
                        Forms\Components\TextInput::make('header_title')
                            ->required(),
                        Forms\Components\Textarea::make('header_description')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Fieldset::make('Features Section')
                    ->schema([
                        \Filament\Schemas\Components\Group::make([
                            Forms\Components\TextInput::make('feature_1_title')
                                ->label('Feature 1 Title')
                                ->required(),
                            Forms\Components\Textarea::make('feature_1_description')
                                ->label('Feature 1 Description')
                                ->required(),
                        ])->columnSpan(1),
                        
                        \Filament\Schemas\Components\Group::make([
                            Forms\Components\TextInput::make('feature_2_title')
                                ->label('Feature 2 Title')
                                ->required(),
                            Forms\Components\Textarea::make('feature_2_description')
                                ->label('Feature 2 Description')
                                ->required(),
                        ])->columnSpan(1),

                        \Filament\Schemas\Components\Group::make([
                            Forms\Components\TextInput::make('feature_3_title')
                                ->label('Feature 3 Title')
                                ->required(),
                            Forms\Components\Textarea::make('feature_3_description')
                                ->label('Feature 3 Description')
                                ->required(),
                        ])->columnSpan(1),
                    ])->columns(3),

                \Filament\Schemas\Components\Fieldset::make('Red Banner Section')
                    ->schema([
                        Forms\Components\TextInput::make('banner_title')
                            ->required(),
                        Forms\Components\Textarea::make('banner_description')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('header_title')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
