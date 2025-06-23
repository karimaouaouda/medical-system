<?php

namespace App\Traits;

use App\Enums\MedicationTime;
use App\Enums\UserRoles;
use App\Models\PatientProfile;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * @mixin User
 */
trait HasPatientRole
{

    public function doctors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follow_requests',
            'patient_id',
            'doctor_id'
        )->withPivot(['status']);
    }
    public function isFollowing(User $doctor): bool
    {
        return DB::table('follow_requests')
            ->where('doctor_id', $doctor->id)
            ->where('patient_id', Auth::id())
            ->where('status', 'accepted')
            ->exists();
    }

    public function hasPendingRequestFor(User $doctor): bool
    {
        return DB::table('follow_requests')
            ->where('doctor_id', $doctor->id)
            ->where('patient_id', Auth::id())
            ->where('status', 'pending')
            ->exists();
    }

    public function follow(User $doctor): true
    {
        if( $this->isFollowing($doctor) || $this->hasPendingRequestFor($doctor) )
        {
            return true;
        }

        DB::table('follow_requests')->insert([
            'patient_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'status' => 'pending'
        ]);

        return true;
    }

    public function unfollow(User $doctor): true
    {
        DB::table('follow_requests')
            ->where('patient_id', Auth::id())
            ->where('doctor_id', $doctor->id)
            ->delete();

        return true;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(\App\Models\Review::class, 'patient_id');
    }

    public function isPatient() : bool
    {
        return $this->getAttribute('role') == UserRoles::PATIENT;
    }

    public function treatments() : HasMany
    {
        return $this->hasMany(Treatment::class, 'patient_id');
    }

    public function getHourFor(string $at): int|string
    {

        if( !$this->isPatient() ){
            return 0;
        }

        $profile = $this->patientProfile;
        $hour = '08:00:00';

        if( !$profile ){
            throw new Exception('patient must have profile');
        }

        $meals = $profile->meals ? $profile->meals[0] : null;

        if( $meals && in_array($at, [MedicationTime::BEFORE_BREAKFAST->value, MedicationTime::MIDDLE_BREAKFAST->value, MedicationTime::AFTER_BREAKFAST->value]) )
        {
            list($hour, $minute) = explode(':', $meals['breakfast']);

            return (int) $hour; // Convert to integer
        }

        if($meals && in_array($at, [MedicationTime::BEFORE_LUNCH->value, MedicationTime::MIDDLE_LUNCH->value, MedicationTime::AFTER_LUNCH->value]))
        {
            list($hour, $minute) = explode(':', $meals['lunch']);

            return (int) $hour; // Convert to integer
        }

        if ($meals){
            list($hour, $minute) = explode(':', $meals['dinner']);
        }

        return (int) $hour; // Convert to integer

    }

    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class);
    }
}
