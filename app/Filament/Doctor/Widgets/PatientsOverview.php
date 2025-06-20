<?php

namespace App\Filament\Doctor\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->patientsCountStat(),
            $this->reviewsCountStat(),
            $this->rateAvgStat()
        ];
    }

    private function patientsCountStat(): Stat
    {
        return Stat::make('patients', Filament::auth()->user()->patients()->count())
            ->description('you patients count')
            ->icon('heroicon-o-users');
    }

    private function reviewsCountStat(): Stat
    {
        return Stat::make('reviews', Filament::auth()->user()->profile->reviews()->count())
            ->description('reviews count')
            ->icon('heroicon-o-squares-plus');
    }

    private function rateAvgStat(): Stat
    {
        return Stat::make('rate average', Filament::auth()->user()->profile->reviews()->avg('rate') ?? 0)
            ->description('rating avg')
            ->icon('heroicon-o-star');
    }
}
