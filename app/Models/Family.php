<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    /** @use HasFactory<\Database\Factories\FamilyFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public function users()
    {
        return $this->hasMany(User::class)->orderBy('created_at', 'DESC');
    }
}
