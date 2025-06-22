<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_percentage',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
