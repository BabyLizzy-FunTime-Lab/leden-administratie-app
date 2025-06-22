<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'family_id',
        'family_role_id',
        'membership_id',
        'access_level_id',
        'contribution_id',
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
        ];
    }

    public function familyRole()
    {
        return $this->belongsTo(FamilyRole::class);
    }

    public function accessLevel()
    {
        return $this->belongsTo(AccessLevel::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }
}
