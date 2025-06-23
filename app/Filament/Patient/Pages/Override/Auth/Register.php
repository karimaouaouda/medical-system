<?php

namespace App\Filament\Patient\Pages\Override\Auth;

use App\Enums\UserRole;
use App\Enums\UserRoles;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Validation\Rules\Enum;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        Hidden::make('role')
                            ->default(UserRoles::PATIENT->value)
                            ->required()
                            ->rule(new Enum(UserRole::class)),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
