<?php

namespace App\Filament\Doctor\Pages;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageAppointments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.doctor.pages.manage-appointments';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Appointment::query()->where('doctor_id', auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')->label('Patient'),
                Tables\Columns\TextColumn::make('scheduled_at')->dateTime(),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->actions([
                Action::make('accept')
                    ->label('Accept')
                    ->visible(fn (Appointment $record) => $record->status === AppointmentStatus::Pending)
                    ->action(fn (Appointment $record) => $record->update(['status' => AppointmentStatus::Accepted])),
                Action::make('decline')
                    ->label('Decline')
                    ->color('danger')
                    ->visible(fn (Appointment $record) => $record->status === AppointmentStatus::Pending)
                    ->action(fn (Appointment $record) => $record->update(['status' => AppointmentStatus::Declined])),
                EditAction::make()
                    ->form([
                        DateTimePicker::make('scheduled_at')->required(),
                    ]),
            ]);
    }
}
