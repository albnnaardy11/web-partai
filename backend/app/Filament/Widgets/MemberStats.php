<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Anggota', Member::count())
                ->description('Total anggota terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Pending Approval', Member::where('status', 'pending')->count())
                ->description('Pendaftaran perlu diverifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
