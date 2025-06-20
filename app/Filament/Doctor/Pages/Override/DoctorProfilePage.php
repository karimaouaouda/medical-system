<?php

namespace App\Filament\Doctor\Pages\Override;

use App\Models\Geo\City;
use App\Models\Geo\Country;
use App\Models\Geo\State;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;

class DoctorProfilePage extends EditProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.doctor.pages.doctor-profile';

    protected ?string $heading = "Profile Settings";

    public array $address = [
        'country_id' => '',
        'state_id' => '',
        'city_id' => '',
        'street_line_1' => '',
        'street_line_2' => '',
        'postal_code' => '',
    ];

    public array $contact = [
        'email' => '',
        'phone_number' => '',
        'website' => ''
    ];

    public array $work = [
        'biography' => '',
        'work_hours' => [],
        'languages' => []
    ];

    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);

        $address = Auth::user()->address()->first()?->toArray() ?? $this->address;

        $contact = Auth::user()->contact()->first()?->toArray() ?? $this->contact;

        $work = Auth::user()->profile()->first()?->toArray() ?? $this->work;

        $work['work_hours'] = is_array($work['work_hours']) ? $work['work_hours'] : json_decode($work['work_hours'], true);

        $this->address_form->fill($address);

        $this->contact_form->fill($contact);

        $this->work_form->fill($work);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }



    public function PersonalInformationForm(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->description('Provide your basic personal details. This information helps identify you on the platform and ensures accurate communication and profile visibility.')
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->schema([
                        $this->getAvatarFormComponent(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('save')
                                ->action('save')
                        ])
                    ])
            ])
            ->operation('edit')
            ->model($this->getUser())
            ->statePath('data')
            ->inlineLabel(! static::isSimple());
    }

    public function addressInformationForm(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('address')
            ->schema([
                Section::make('Address Information')
                    ->icon('heroicon-o-map-pin')
                    ->description('Enter your current practice or residence address. This helps patients and colleagues locate your services and ensures accurate regional listings.')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('full_name', 'id'))
                            ->searchable()
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('state_id')
                            ->label('State')
                            ->live()
                            ->searchable()
                            ->options(function (Forms\Get $get){
                                $country = $get('country_id');
                                if(empty($country)){
                                    return [];
                                }

                                return State::query()->where('country_id', $country)->get()->pluck('name', 'id');
                            })
                            ->required(),
                        Forms\Components\Select::make('city_id')
                            ->options(function (Forms\Get $get){
                                $state = $get('state_id');
                                if(empty($state)){
                                    return [];
                                }

                                return City::query()->where('state_id', $state)->get()->pluck('name', 'id');
                            })
                            ->label('City')
                            ->required(),
                        Forms\Components\TextInput::make('street_line_1')
                            ->label('Street Line 1')
                            ->required(),
                        Forms\Components\TextInput::make('street_line_2')
                            ->label('Street Line 2')
                            ->nullable(),
                        Forms\Components\TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->required(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('save')
                                ->action('saveAddress')
                                ->color(Color::Green)
                        ])
                    ])
            ]);
    }

    public function contactInformationForm(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('contact')
            ->schema([
                Section::make('contact information')
                    ->icon('heroicon-o-phone')
                    ->description('Add your phone number and email address so patients and platform \
                    administrators can reach you when needed.')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->nullable()
                            ->unique('contacts', 'phone_number')
                            ->tel(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique('contacts', 'email')
                            ->required(),
                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->nullable(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('save')
                                ->action('saveContact')
                        ])
                    ])
            ]);
    }

    public function workInformationForm(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('work')
            ->schema([
                Section::make('Work Information')
                    ->description('Add your languages and working hours to help patients connect and book appointments easily.')
                    ->icon('heroicon-o-building-storefront')
                    ->collapsible()
                    ->schema([
                        // bio, work hours
                        Forms\Components\Textarea::make('biography')
                            ->maxLength(500)
                            ->required(),
                        Forms\Components\Repeater::make('languages')
                            ->minItems(1)
                            ->schema([
                                Forms\Components\Select::make('name')
                                    ->options([
                                        'en' => "English",
                                        'ar' => "Arabic",
                                        'fr' => "French",
                                        'es' => "Spanish",
                                    ])
                            ]),
                        Forms\Components\Repeater::make('work_hours')
                            ->minItems(1)
                            ->label('Work Hours')
                            ->schema([
                                Forms\Components\Select::make("day")
                                    ->options([
                                        'Monday' => 'Monday',
                                        'Tuesday' => 'Tuesday',
                                        'Wednesday' => 'Wednesday',
                                        'Thursday' => 'Thursday',
                                        'Saturday' => 'Saturday',
                                        'Sunday' => 'Sunday',
                                    ])
                                    ->default('Sunday')
                                    ->required(),
                                Forms\Components\TimePicker::make('from_hour')
                                    ->required(),
                                Forms\Components\TimePicker::make('to_hour')
                                    ->required(),
                            ]),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('save')
                                ->action('saveWork')
                        ])
                    ])
            ]);
    }


    protected function getForms(): array
    {
        return [
            'form' => $this->PersonalInformationForm(
                $this->makeForm()
            ),
            'address_form' => $this->addressInformationForm(
                $this->makeForm()
            ),
            'contact_form' => $this->contactInformationForm(
                $this->makeForm()
            ),
            'work_form' => $this->workInformationForm(
                $this->makeForm()
            )
        ];
    }

    private function getAvatarFormComponent() : FileUpload
    {
        return FileUpload::make('avatar')
            ->disk('public')
            ->directory('users-avatar')
            ->avatar();

    }




    function saveAddress()
    {
        try{
            $address = Auth::user()->address()->firstOrCreate([], $this->address);

            $address->update($this->address);

            Notification::make()
                ->title('saved')
                ->success()
                ->send();
        }catch (\Exception $e){
            Notification::make()
                ->title('error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function saveContact()
    {
        try{
            $contact = Auth::user()->contact()->firstOrCreate([], $this->contact);

            $contact->update($this->contact);

            Notification::make()
                ->title('saved')
                ->success()
                ->send();
        }catch (\Exception $e){
            Notification::make()
                ->title('error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function saveWork()
    {
        try{
            $this->work['work_hours'] = json_encode($this->work['work_hours']);
            $this->work['languages'] = json_encode($this->work['languages']);

            $work = Auth::user()->profile()->firstOrCreate([], $this->work);

            $work->update($this->work);

            $this->work['work_hours'] = json_decode($this->work['work_hours'], true);
            $this->work['languages'] = json_decode($this->work['languages'], true);

            Notification::make()
                ->title('saved')
                ->success()
                ->send();
        }catch (\Exception $e){
            Notification::make()
                ->title('error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
