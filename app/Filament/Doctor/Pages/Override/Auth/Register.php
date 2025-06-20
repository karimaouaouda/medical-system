<?php

namespace App\Filament\Doctor\Pages\Override\Auth;

use App\Enums\UserRole;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Form;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\Rules\Enum;

class Register extends BaseRegister
{

    protected ?string $maxWidth = '2xl';

    protected ?string $heading = "sign up - doctor";

    protected static ?string $title = "sign up - doctor";

    public function getHeading(): string|Htmlable
    {
        return $this->heading;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make('Personal Information')
                                ->schema([
                                    $this->getNameFormComponent(),
                                    $this->getEmailFormComponent(),
                                    Hidden::make('role')
                                        ->default(UserRole::Doctor->value)
                                        ->required()
                                        ->rule(new Enum(UserRole::class)),
                                    $this->getPasswordFormComponent(),
                                    $this->getPasswordConfirmationFormComponent(),
                                ]),
                            Wizard\Step::make('work Information')
                                ->schema([
                                    Select::make('speciality_id')
                                        ->label('Speciality')
                                        ->options(function () {
                                            return \App\Models\Speciality::all()->pluck('name', 'id');
                                        }),
                                    FileUpload::make('document_path')
                                        ->required()
                                        ->disk('public')
                                        ->directory('documents')
                                        ->label('Documents')
                                        ->helperText('you must provide a PDF file containing the necessary docs'),
                                    Actions::make([
                                        Actions\Action::make('download requirements file')
                                            ->url(route('download.requirements'))
                                    ])
                                ])
                        ])
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
    public function register(): ?RegistrationResponse
    {
        try {

            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function () {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            $user->profile()->create([
                'speciality_id' => $data['speciality_id']
            ]);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }
}
