<?php

namespace App\Filament\Doctor\Pages;

use App\Enums\FollowRequestStatus;
use App\Models\FollowRequest;
use Filament\Tables\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageFollowRequests extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static string $view = 'filament.doctor.pages.manage-follow-requests';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => FollowRequest::query()->where('doctor_id', auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')->label('Patient'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->actions([
                Action::make('accept')
                    ->label('Accept')
                    ->visible(fn (FollowRequest $record) => $record->status === FollowRequestStatus::Pending)
                    ->action(fn (FollowRequest $record) => $record->update(['status' => FollowRequestStatus::Accepted])),
                Action::make('decline')
                    ->label('Decline')
                    ->color('danger')
                    ->visible(fn (FollowRequest $record) => $record->status === FollowRequestStatus::Pending)
                    ->action(fn (FollowRequest $record) => $record->update(['status' => FollowRequestStatus::Declined])),
            ]);
    }
}
