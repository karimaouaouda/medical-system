<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\UserRole;
use App\Filament\Doctor\Resources\PatientResource\Pages;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Patient';

    protected static ?string $pluralLabel = 'Patients';



    public static function getEloquentQuery(): Builder
    {
        return User::query()->whereHas('patients', function (Builder $query){
            return $query->where('doctor_id', Filament::auth()->id());
        });
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Hidden::make('role')
                    ->default(UserRole::Patient->value),
                Forms\Components\TextInput::make('name')
                    ->prefixIcon('heroicon-o-user')
                    ->placeholder('user name'),
                Forms\Components\TextInput::make('email')
                    ->prefixIcon('heroicon-o-envelope')
                    ->email()
                    ->unique('users', 'email'),
                Forms\Components\TextInput::make('password')
                    ->prefixIcon('heroicon-o-lock-closed')
                    ->minLength(8)
                    ->password(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->prefix('#')
                    ->badge(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('chat with')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->url(function (User $record){
                        return route('user', [
                            'id' => $record->id
                        ]);
                    })
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
