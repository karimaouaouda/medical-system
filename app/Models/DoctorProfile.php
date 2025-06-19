<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'speciality_id',
        'biography',
        'languages',
        'work_hours',
    ];

    protected $casts = [
        'work_hours' => 'array',
        'languages' => "array"
    ];

    public function getWorkHoursAttribute()
    {
        if (! $this->attributes['work_hours']) {
            return [];
        }

        return is_array($this->attributes['work_hours']) ?
            $this->attributes['work_hours'] :
            json_decode($this->attributes['work_hours'], true);
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'doctor_id');
    }

    public function speciality(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }
}
