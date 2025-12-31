<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChairpersonMessageResource\Pages;
use App\Models\ChairpersonMessage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions;

class ChairpersonMessageResource extends Resource
{
    protected static ?string $model = ChairpersonMessage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationLabel = 'Chairperson Message';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Fieldset::make('Header Section')
                    ->schema([
                        Forms\Components\TextInput::make('header_badge')
                            ->required()
                            ->default('Sambutan Ketua Umum'),
                        Forms\Components\TextInput::make('header_title')
                            ->required()
                            ->default('Pesan dari Ibu Ketua'),
                    ]),

                \Filament\Schemas\Components\Fieldset::make('Chairperson Info')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->directory('chairperson')
                            ->visibility('public')
                            ->required(),
                        Forms\Components\TextInput::make('chairperson_name')
                            ->required()
                            ->default('Ibu Siti Rahmawati'),
                        Forms\Components\TextInput::make('chairperson_title')
                            ->required()
                            ->default('Ketua Umum Partai Ibu'),
                    ])->columns(2),

                \Filament\Schemas\Components\Fieldset::make('Message Content')
                    ->schema([
                        Forms\Components\TextInput::make('message_greeting')
                            ->required()
                            ->default('Assalamu’alaikum warahmatullahi wabarakatuh'),
                        Forms\Components\Textarea::make('message_content')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Fieldset::make('Signature & Extras')
                    ->schema([
                        Forms\Components\TextInput::make('signature_greeting')
                            ->required()
                            ->default('Wassalamu’alaikum warahmatullahi wabarakatuh'),
                        Forms\Components\TextInput::make('philosophy_text')
                            ->required()
                            ->default('Indonesia adalah keluarga besar kita'),
                        Forms\Components\TextInput::make('commitment_text')
                            ->required()
                            ->default('Kepedulian untuk setiap anak bangsa'),
                    ])->columns(2),

                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->circular(),
                Tables\Columns\TextColumn::make('chairperson_name')
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
            'index' => Pages\ListChairpersonMessages::route('/'),
            'create' => Pages\CreateChairpersonMessage::route('/create'),
            'edit' => Pages\EditChairpersonMessage::route('/{record}/edit'),
        ];
    }
}
