<?php

namespace App\Filament\Admin\Pages;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApproveDoctors extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static string $view = 'filament.admin.pages.approve-doctors';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query()->where('role', UserRole::Doctor)->whereNull('approved_at'))
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('document_path')->label('Document'),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->action(fn (User $record) => $record->update(['approved_at' => now()])),
            ]);
    }
}
