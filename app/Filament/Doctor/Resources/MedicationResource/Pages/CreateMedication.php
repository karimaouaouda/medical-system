<?php

namespace App\Filament\Doctor\Resources\MedicationResource\Pages;

use App\Filament\Doctor\Resources\MedicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedication extends CreateRecord
{
    protected static string $resource = MedicationResource::class;
}
