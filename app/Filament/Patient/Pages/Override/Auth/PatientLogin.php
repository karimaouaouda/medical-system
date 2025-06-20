<?php

namespace App\Filament\Patient\Pages\Override\Auth;

use Filament\Pages\Auth\Login;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class PatientLogin extends Login
{
    protected ?string $heading = "sign in - patient";

    public function getHeading(): string|Htmlable
    {
        return $this->heading;
    }
}
