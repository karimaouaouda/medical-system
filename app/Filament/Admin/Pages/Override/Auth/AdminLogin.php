<?php

namespace App\Filament\Admin\Pages\Override\Auth;

use Filament\Pages\Auth\Login;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class AdminLogin extends Login
{

    protected ?string $heading = "sign in - admin";

    public function getHeading(): string|Htmlable
    {
        return $this->heading;
    }
}
