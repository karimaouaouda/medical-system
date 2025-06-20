<?php

namespace App\Filament\Doctor\Pages\Override\Auth;

use Filament\Pages\Auth\Login;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class DoctorLogin extends Login
{
    protected ?string $heading = "sign in - doctor";

    public function getHeading(): string|Htmlable
    {
        return $this->heading;
    }
}
