<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasAddress;
use App\Traits\HasContact;
use App\Traits\HasProfile;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Enums\UserRole;
use App\Models\FollowRequest;
use App\Models\Appointment;
use App\Traits\HasDoctorRole;
use App\Traits\HasPatientRole;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        Notifiable,
        HasPatientRole,
        HasDoctorRole,
        HasContact,
        HasProfile,
        HasAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'date_of_birth',
        'avatar',
        'document_path',
        'approved_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function receivedFollowRequests()
    {
        return $this->hasMany(FollowRequest::class, 'doctor_id');
    }

    public function sentFollowRequests()
    {
        return $this->hasMany(FollowRequest::class, 'patient_id');
    }

    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->getAttribute('role')->value == $panel->getId();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if( $this->getAttribute('avatar') )
        {
            Str::startsWith($this->getAttribute('avatar'), 'users-avatar') ?
                $img_name = explode('/', $this->getAttribute('avatar'))[1] :
                $img_name = $this->getAttribute('avatar');

            return asset('storage/users-avatar/' . $img_name);
        }

        return "https://ui-avatars.com/api/?name=" . $this->getAttribute('name') . "&color=FFFFFF&background=09090b";

    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->getFilamentAvatarUrl();
    }
}
