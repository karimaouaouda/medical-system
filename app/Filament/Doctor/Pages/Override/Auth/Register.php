<?php

namespace App\Filament\Doctor\Pages\Override\Auth;

use App\Enums\UserRole;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Form;
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
                        TextInput::make('role')
                            ->default(UserRole::Doctor->value)
                            ->required()
                            ->rule(new Enum(UserRole::class)),
                        FileUpload::make('document')
                            ->required()
                            ->disk('public')
                            ->directory('documents')
                            ->label('Documents')
                            ->helperText('See steps: '.url('doctor-registration-steps.txt')),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['document'])) {
            $data['document_path'] = $data['document'];
            unset($data['document']);
        }

        $data['approved_at'] = null;

        return $data;
    }
}
