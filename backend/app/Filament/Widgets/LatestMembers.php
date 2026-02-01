<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestMembers extends TableWidget
{
    protected static ?int $sort = 2; // Below the stats overview
    
    protected int | string | array $columnSpan = 'full'; // Make it wide

    protected static ?string $heading = 'Pendaftaran Anggota Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Member::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Kota'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                \Filament\Actions\Action::make('view')
                    ->label('Detail')
                    ->url(fn (Member $record): string => \App\Filament\Resources\MemberResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-eye'),
            ]);
    }
}
