<?php

namespace App\Traits;

use App\Enums\UserRoles;
use App\Models\DoctorProfile;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasDoctorRole
{
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follow_requests', 'doctor_id', 'patient_id')
            ->wherePivot('status', 'accepted');
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function isDoctor() : bool
    {
        return $this->getAttribute('role') == UserRoles::DOCTOR;
    }

    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class, 'doctor_id');
    }

    public function getPatientsCountAttribute(): int
    {
        return $this->patients()->count();
    }

    public function getExperienceYearsAttribute(): int
    {
        return 12;
    }

    public function getRatingAttribute(): float|int
    {
        return 4.2;
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->profile->reviews()->count();
    }

    public function getLanguagesArrayAttribute(): array
    {
        $languages = $this->profile->languages;
        $languages = is_array($languages) ? $languages : json_decode($languages, true);
        $langarr = [];
        foreach ($languages as $key => $language) {
            $langarr[] = $language['name'];
        }

        return $langarr;
    }

    public function getSpecialityAttribute(){

        return $this->doctorProfile->speciality->name ?? "Cardiologist";
    }
}
