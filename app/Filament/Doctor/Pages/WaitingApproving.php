<?php

namespace App\Filament\Doctor\Pages;

use Filament\Pages\SimplePage;

class WaitingApproving extends SimplePage
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.doctor.pages.waiting-approving';

    protected static bool $shouldRegisterNavigation = false;


}
