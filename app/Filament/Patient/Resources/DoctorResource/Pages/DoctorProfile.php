<?php

namespace App\Filament\Patient\Resources\DoctorResource\Pages;

use App\Filament\Patient\Resources\DoctorResource;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Mokhosh\FilamentRating\Components\Rating;

class DoctorProfile extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    protected static string $view = 'filament.pages.doctor-profile';

    public array $review = [
        'doctor_id' => '',
        'patient_id' => '',
        'comment' => '',
        'rate' => 0,
    ];

    public function followDoctor(){
        $patient = Filament::auth()->user();

        $patient->follow($this->record);

        Notification::make()
            ->title("request sent")
            ->success()
            ->send();
    }

    public function unfollowDoctor(){
        $patient = Filament::auth()->user();

        $patient->unfollow($this->record);

        Notification::make()
            ->title("request sent")
            ->success()
            ->send();
    }

    public function cancelRequest()
    {
        $patient = Filament::auth()->user();

        $patient->unfollow($this->record);

        Notification::make()
            ->title("request sent")
            ->success()
            ->send();
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $review = Filament::auth()->user()->reviews()->where('doctor_id', $this->record->id)->first();

        if($review){
            $this->review_form->fill($review->toArray());
        }
    }
    public function reviewForm(Form $form): Form
    {
        return $form
            ->statePath('review')
            ->schema([
                Hidden::make('doctor_id')
                    ->default($this->record->id),
                Textarea::make('comment')
                    ->required(),
                Rating::make('rate')
                    ->required(),
                Actions::make([
                    Actions\Action::make('share review')
                        ->action('saveReview')
                        ->color('info'),
                ])

            ]);
    }
    protected function getForms(): array
    {
        return [
            'form' => $this->form(static::getResource()::form(
                $this->makeForm()
                    ->operation('view')
                    ->disabled()
                    ->model($this->getRecord())
                    ->statePath($this->getFormStatePath())
                    ->columns($this->hasInlineLabels() ? 1 : 2)
                    ->inlineLabel($this->hasInlineLabels()),
            )),
            'review_form' => $this->reviewForm($this->makeForm())
        ];
    }

    public function saveReview(){
        $state = $this->review_form->getState();
        $state['doctor_id'] = $this->record->profile->id;
        $review = Filament::auth()->user()->reviews()->updateOrCreate([
            'doctor_id' => $state['doctor_id'],
            'patient_id' => Filament::auth()->id()
        ], $state);
        Notification::make()
            ->title("review created")
            ->success()
            ->send();
    }
}
