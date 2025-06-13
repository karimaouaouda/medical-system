<?php

namespace App\Filament\Patient\Pages;

use App\Enums\FollowRequestStatus;
use App\Enums\UserRole;
use App\Models\FollowRequest;
use App\Models\User;
use Filament\Pages\Page;

class SearchDoctors extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.patient.pages.search-doctors';

    public string $search = '';

    public string $sort = 'name';

    public function getDoctorsProperty()
    {
        return User::query()
            ->where('role', UserRole::Doctor)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sort)
            ->get();
    }

    public function requestFollow(int $doctorId): void
    {
        FollowRequest::firstOrCreate([
            'doctor_id' => $doctorId,
            'patient_id' => auth()->id(),
        ], [
            'status' => FollowRequestStatus::Pending,
        ]);
    }

    public function hasRequested(User $doctor): bool
    {
        return FollowRequest::where('doctor_id', $doctor->id)
            ->where('patient_id', auth()->id())
            ->exists();
    }
}
