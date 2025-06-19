<?php

namespace App\Traits;

use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\User;

/**
 * @mixin User
*/
trait HasProfile
{
    /**
     * @throws \Exception
     */
    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne|HasProfile
    {
        switch ($this->getAttribute('role')->value)
        {
            case 'patient':
                return $this->hasOne(PatientProfile::class);
                break;
            case 'doctor':
                return $this->hasOne(DoctorProfile::class);
                break;
            default:
                return $this;
        }
    }
}
