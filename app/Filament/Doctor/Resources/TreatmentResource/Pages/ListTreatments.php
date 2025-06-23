<?php

namespace App\Filament\Doctor\Resources\TreatmentResource\Pages;

use App\Filament\Doctor\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTreatments extends ListRecords
{
    protected static string $resource = TreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
