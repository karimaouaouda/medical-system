<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @mixin User
 */
trait HasPatientRole
{
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
}
