<?php

namespace App\Filament\Patient\Pages\Override;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile;
use Filament\Pages\Page;

class PatientProfilePage extends EditProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.patient.pages.patient-profile';

    public array $profile = [
        'height' => '',
        'weight' => '',
        'blood_type' => '',
    ];
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getAvatarFormComponent(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
            ),
        ];
    }

    private function getAvatarFormComponent() : FileUpload
    {
        return FileUpload::make('avatar')
                    ->disk('public')
                    ->directory('users-avatar')
                    ->avatar();

    }


    private function getProfileInformationFormComponents(): array
    {
        return [
            Section::make('Profile Information')
                ->icon('heroicon-o-user-circle')
                ->description('Please provide accurate profile information.')
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextInput::make('user_id')
                        ->label('User ID')
                        ->required()
                        ->numeric(),
                    Select::make('blood_type')
                        ->label('Blood Type')
                        ->options([
                            'A+' => 'A+',
                            'A-' => 'A-',
                            'B+' => 'B+',
                            'B-' => 'B-',
                            'AB+' => 'AB+',
                            'AB-' => 'AB-',
                            'O+' => 'O+',
                            'O-' => 'O-',
                        ])
                        ->required(),
                    TextInput::make('weight')
                        ->label('Weight (kg)')
                        ->required()
                        ->numeric()
                        ->minValue(30)
                        ->maxValue(300),
                    TextInput::make('height')
                        ->label('Height (cm)')
                        ->required()
                        ->numeric()
                        ->minValue(50)
                        ->maxValue(300),
                    Actions::make([
                        Actions\Action::make('save')
                            ->action('saveProfileInfo')
                    ])
                ])
        ];
    }


    public function profileInformationForm(Form $form): Form
    {
        return $form
            ->statePath('profile')
            ->schema($this->getProfileInformationFormComponents());

    }

    public function saveProfileInfo()
    {
        try {
            $data = $this->profileInformationForm->getState();
            // Validate and save the data to the database
            $this->validate([
                'profile.height' => 'required|numeric|min:50|max:300',
                'profile.weight' => 'required|numeric|min:30|max:300',
                'profile.blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            ]);

            // Assuming the logged-in user is being updated
            $user = $this->getUser();
            $user->profile->update([
                'height' => $data['height'],
                'weight' => $data['weight'],
                'blood_type' => $data['blood_type'],
            ]);

            // Provide feedback for successful save
            session()->flash('success', 'Profile information updated successfully.');
        } catch (\Exception $e) {
            // Log or handle the exception, provide feedback
            session()->flash('error', 'Failed to update profile information. Please try again.');
        }
    }

}
