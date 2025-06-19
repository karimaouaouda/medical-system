<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasDoctorRole
{
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follow_requests', 'doctor_id', 'patient_id')
            ->wherePivot('status', 'accepted');
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

    public function getLanguagesArrayAttribute()
    {
        $languages = $this->profile->languages;
        $langarr = [];
        foreach ($languages as $key => $language) {
            $langarr[] = $language['name'];
        }

        return $langarr;
    }

    public function getSpecialityAttribute(){

        return $this->profile->speciality->name;
    }
}
