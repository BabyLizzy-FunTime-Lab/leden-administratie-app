<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    /** @use HasFactory<\Database\Factories\AccessLevelFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
