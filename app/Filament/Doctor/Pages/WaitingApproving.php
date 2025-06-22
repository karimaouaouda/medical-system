<?php

namespace App\Filament\Doctor\Pages;

use Filament\Pages\Page;
use Filament\Pages\SimplePage;

class WaitingApproving extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.doctor.pages.waiting-approving';
    protected static bool $shouldRegisterNavigation = false;

    public function getLayout(): string
    {
        return 'filament-panels::components.layout.simple';
    }

    public function hasLogo(): bool
    {
        return true;
    }


}
