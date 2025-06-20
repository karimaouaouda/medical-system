<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->doctorsStat(),
            $this->patientsStat(),
            $this->adminsStat()
        ];
    }

    private function doctorsStat(): Stat
    {
        return Stat::make('doctors', User::where('role', UserRole::Doctor->value)->count())
            ->description('count of doctors')
            ->icon('heroicon-o-users')
            ->color(Color::Green);
    }

    private function patientsStat(): Stat
    {
        return Stat::make('patients', User::where('role', UserRole::Patient->value)->count())
            ->description('count of patients')
            ->icon('heroicon-o-users')
            ->color(Color::Indigo);

    }

    private function adminsStat(): Stat
    {
        return Stat::make('admins', User::where('role', UserRole::Doctor->value)->count())
            ->description('count of admins')
            ->icon('heroicon-o-users')
            ->color(Color::Blue);
    }
}
