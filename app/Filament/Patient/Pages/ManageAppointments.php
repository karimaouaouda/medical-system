<?php

namespace App\Filament\Patient\Pages;

use App\Enums\AppointmentStatus;
use App\Enums\FollowRequestStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageAppointments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.patient.pages.manage-appointments';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Appointment::query()->where('patient_id', auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('doctor.name')->label('Doctor'),
                Tables\Columns\TextColumn::make('scheduled_at')->dateTime(),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Select::make('doctor_id')
                            ->label('Doctor')
                            ->options(
                                User::where('role', UserRole::Doctor)
                                    ->whereHas('receivedFollowRequests', function ($query) {
                                        $query->where('patient_id', auth()->id())
                                            ->where('status', FollowRequestStatus::Accepted);
                                    })
                                    ->pluck('name', 'id')
                            )
                            ->required(),
                        DateTimePicker::make('scheduled_at')->required(),
                    ])
                    ->using(function (array $data) {
                        $data['patient_id'] = auth()->id();
                        $data['status'] = AppointmentStatus::Pending;
                        Appointment::create($data);
                    }),
            ]);
    }
}
