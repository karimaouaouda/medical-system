<?php

namespace App\Filament\Doctor\Resources\PatientResource\Pages;

use App\Filament\Doctor\Resources\PatientResource;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        $patient = User::query()->create($data);

        $patient->doctors()->attach([Filament::auth()->id()], [
            'status' => 'accepted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $patient;
    }
}
